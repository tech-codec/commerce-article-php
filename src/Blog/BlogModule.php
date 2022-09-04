<?php

namespace App\Blog;

use Framework\Renderer;
use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{

    private $renderer;

    public function __construct(Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath(__DIR__ . '/views', 'blog',);
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-0-9]+}', [$this, 'show'], 'blog.show');
    }

    public function index(Request $request): String
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(Request $request): String
    {
        return $this->renderer->render('@blog/show', ['slug' => $request->getAttribute('slug')]);
    }
}
