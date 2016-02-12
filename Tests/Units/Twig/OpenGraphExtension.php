<?php

namespace Novaway\Bundle\OpenGraphBundle\Tests\Units\Twig;

use atoum;

class OpenGraphExtension extends atoum
{
    public function testRenderNamespaceAttributesFunction()
    {
        $this
            ->given(
                $renderer = new \mock\Novaway\Component\OpenGraph\View\OpenGraphRendererInterface(),
                $graph = new \mock\Novaway\Component\OpenGraph\OpenGraphInterface()
            )
            ->if($this->newTestedInstance($renderer))
            ->then
                ->given($this->testedInstance->renderNamespaceFunction($graph))
                ->mock($renderer)
                    ->call('renderNamespaceAttributes')
                        ->withAtLeastArguments([$graph])->once()
        ;
    }

    public function testRenderGraphFunction()
    {
        $this
            ->given(
                $renderer = new \mock\Novaway\Component\OpenGraph\View\OpenGraphRendererInterface(),
                $graph = new \mock\Novaway\Component\OpenGraph\OpenGraphInterface()
            )
            ->if($this->newTestedInstance($renderer))
            ->then
                ->given($this->testedInstance->renderGraphFunction($graph))
                    ->mock($renderer)
                        ->call('render')
                            ->withAtLeastArguments([$graph])->once()
        ;
    }

    public function testRenderTagFunction()
    {
        $this
            ->given(
                $renderer = new \mock\Novaway\Component\OpenGraph\View\OpenGraphRendererInterface(),
                $tag = new \mock\Novaway\Component\OpenGraph\OpenGraphTagInterface()
            )
            ->if($this->newTestedInstance($renderer))
            ->then
                ->given($this->testedInstance->renderTagFunction($tag))
                    ->mock($renderer)
                        ->call('renderTag')
                            ->withAtLeastArguments([$tag])->once()
        ;
    }
}

