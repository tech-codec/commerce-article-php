<?php

namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{

    private $renderer;

    public function setUp(): void
    {
        $this->renderer = new Renderer;
        $this->renderer->addPath(__DIR__ . '/views');
    }


    public function testRenderTheRightpath()
    {
        $this->renderer->addPath(__DIR__ . '/views', 'blog');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Salut les gens', $content);
    }

    public function testRenderDefaultpath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut les gens', $content);
    }


    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoparams', ['nom' => 'marc']);
        $this->assertEquals('Salut marc', $content);
    }

    public function testRenderGlobalParameters()
    {
        $this->renderer->addGlobal('nom', 'marc');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals('Salut marc', $content);
    }
}
