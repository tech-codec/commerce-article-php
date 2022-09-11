<?php

namespace App\Blog\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


/**
 * cette classe définir les différents actions de notre controller blogmodule (module)
 * en utilisant le render interface
 */
class BlogAction
{


    /**
     * le renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request)
    {
        $slug = $request->getAttribute('slug');
        if ($slug) {
            return $this->show($slug);
        }
        return $this->index();
    }

    public function index(): String
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(string $slug): String
    {
        return $this->renderer->render('@blog/show', ['slug' => $slug]);
    }
}
