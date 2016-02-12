<?php

namespace Novaway\Bundle\OpenGraphBundle\Tests\Units\DependencyInjection;

use atoum;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class NovawayOpenGraphExtension extends atoum
{
    public function testLoadDefault()
    {
        $this
            ->given(
                $extension = $this->newTestedInstance(),
                $container = $this->createContainer()
            )
            ->if($extension->load([], $container))
            ->then
                ->boolean($container->has('novaway.open_graph.metadata.cache'))
                    ->isTrue()
                ->boolean($container->has('novaway.open_graph.generator'))
                    ->isTrue()
                ->object($container->get('novaway.open_graph.generator'))
                    ->isInstanceOf('Novaway\Component\OpenGraph\OpenGraphGenerator')
        ;
    }

    public function testLoadNoCache()
    {
        $this
            ->given(
                $extension = $this->newTestedInstance(),
                $container = $this->createContainer(),
                $configuration = [['metadata' => ['cache' => 'none']]]
            )
            ->if($extension->load($configuration, $container))
            ->then
                ->boolean($container->has('novaway.open_graph.metadata.cache'))
                    ->isFalse()
        ;
    }

    public function testLoadCacheOverride()
    {
        $this
            ->given(
                $extension = $this->newTestedInstance(),
                $container = $this->createContainer(),
                $configuration = [['metadata' => [
                    'cache'      => 'file',
                    'file_cache' => ['dir' => sys_get_temp_dir().'/my-cache']
                ]]]
            )
            ->if($extension->load($configuration, $container))
            ->then
                ->boolean($container->has('novaway.open_graph.metadata.cache'))
                    ->isTrue()
                ->string($container->getDefinition('novaway.open_graph.metadata.file_cache')->getArgument(0))
                    ->isEqualTo(sys_get_temp_dir().'/my-cache')
        ;
    }

    public function testLoadWithBundles()
    {
        $this
            ->given(
                $extension = $this->newTestedInstance(),
                $container = $this->createContainer(['kernel.bundles' => [
                    'FrameworkBundle' => 'Symfony\Bundle\FrameworkBundle\FrameworkBundle',
                ]])
            )
            ->if($extension->load([], $container))
            ->then
                ->array($container->get('novaway.open_graph.metadata.file_locator')->getDirs())
                    ->hasKey('Symfony\Bundle\FrameworkBundle')
                    ->string['Symfony\Bundle\FrameworkBundle']->endWith('FrameworkBundle/Resources/config/open-graph')
                    ->hasSize(1)
        ;
    }

    protected function createContainer(array $params = [])
    {
        $params = array_merge([
            'kernel.bundles'   => [],
            'kernel.cache_dir' => sys_get_temp_dir(),
            'kernel.debug'     => false,
        ], $params);

        return new ContainerBuilder(new ParameterBag($params));
    }
}
