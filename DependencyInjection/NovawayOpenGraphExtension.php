<?php

namespace Novaway\Bundle\OpenGraphBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader;

class NovawayOpenGraphExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ('none' === $config['metadata']['cache']) {
            $container->removeAlias('novaway.open_graph.metadata.cache');
        } elseif ('file' === $config['metadata']['cache']) {
            $container
                ->getDefinition('novaway.open_graph.metadata.file_cache')
                ->replaceArgument(0, $config['metadata']['file_cache']['dir'])
            ;
            $dir = $container->getParameterBag()->resolveValue($config['metadata']['file_cache']['dir']);
            if (!file_exists($dir)) {
                if (!$rs = @mkdir($dir, 0777, true)) {
                    throw new \RuntimeException(sprintf('Could not create cache directory "%s".', $dir));
                }
            }
        } else {
            $container->setAlias('novaway.open_graph.metadata.cache', new Alias($config['metadata']['cache'], false));
        }

        $debug = ($config['metadata']['debug'] || $container->getParameter('kernel.debug'));
        $container
            ->getDefinition('novaway.open_graph.metadata_factory')
            ->replaceArgument(2, $debug)
        ;

        $bundles = $container->getParameter('kernel.bundles');

        $directories = [];
        if ($config['metadata']['auto_detection']) {
            foreach ($bundles as $name => $class) {
                $ref = new \ReflectionClass($class);
                $directories[$ref->getNamespaceName()] = dirname($ref->getFileName()).'/Resources/config/open-graph';
            }
        }
        foreach ($config['metadata']['directories'] as $directory) {
            $directory['path'] = rtrim(str_replace('\\', '/', $directory['path']), '/');
            if ('@' === $directory['path'][0]) {
                $bundleName = substr($directory['path'], 1, strpos($directory['path'], '/') - 1);
                if (!isset($bundles[$bundleName])) {
                    throw new \RuntimeException(sprintf('The bundle "%s" has not been registered with AppKernel. Available bundles: %s', $bundleName, implode(', ', array_keys($bundles))));
                }
                $ref = new \ReflectionClass($bundles[$bundleName]);
                $directory['path'] = dirname($ref->getFileName()).substr($directory['path'], strlen('@'.$bundleName));
            }
            $directories[rtrim($directory['namespace_prefix'], '\\')] = rtrim($directory['path'], '\\/');
        }
        $container
            ->getDefinition('novaway.open_graph.metadata.file_locator')
            ->replaceArgument(0, $directories)
        ;
    }
}
