<?php

namespace Novaway\Bundle\OpenGraphBundle\Twig;

use Novaway\Component\OpenGraph\OpenGraphInterface;
use Novaway\Component\OpenGraph\OpenGraphTagInterface;
use Novaway\Component\OpenGraph\View\OpenGraphRendererInterface;

class OpenGraphExtension extends \Twig_Extension
{
    /** @var OpenGraphRendererInterface */
    private $renderer;


    /**
     * Constructor
     *
     * @param OpenGraphRendererInterface $renderer
     */
    public function __construct(OpenGraphRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('renderNamespace', [$this, 'renderNamespaceFunction'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('renderGraph', [$this, 'renderGraphFunction'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('renderTag', [$this, 'renderTagFunction'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Render namespaces
     *
     * @param OpenGraphInterface $graph
     * @param bool               $withTag
     * @return string
     */
    public function renderNamespaceFunction(OpenGraphInterface $graph, $withTag = true)
    {
        return $this->renderer->renderNamespaceAttributes($graph, $withTag);
    }

    /**
     * Render graph
     *
     * @param OpenGraphInterface $graph
     * @param string             $separator
     * @return string
     */
    public function renderGraphFunction(OpenGraphInterface $graph, $separator = PHP_EOL)
    {
        return $this->renderer->render($graph, $separator);
    }

    /**
     * Render graph tag
     *
     * @param OpenGraphTagInterface $tag
     * @return string
     */
    public function renderTagFunction(OpenGraphTagInterface $tag)
    {
        return $this->renderer->renderTag($tag);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'novaway_open_graph_extension';
    }
}
