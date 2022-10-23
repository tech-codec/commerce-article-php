<?php

namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;


/**
 * notre controller qui charge les routes(et les routes a leur tour font appel aux differents actions en collab)
 */
class BlogModule extends Module
{


    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath(__DIR__ . '/views', 'blog',);
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    }
}
