<?php

namespace App\Blog;

use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use App\Blog\Actions\AdminBlogAction;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;

/**
 * notre controller qui charge les routes(et les routes a leur tour font appel aux differents actions en collab)
 */
class BlogModule extends Module
{


    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container)
    {
        $router = $container->get(Router::class);
        $container->get(RendererInterface::class)->addPath(__DIR__ . '/views', 'blog',);
        $router->get($container->get('blog.prefix'), BlogAction::class, 'blog.index');
        $router->get($container->get('blog.prefix') . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/posts", AdminBlogAction::class, 'blog.admin');
        }
    }
}
