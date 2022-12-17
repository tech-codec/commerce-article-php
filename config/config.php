<?php

/**
 * fichier de configuration de nos différents dépendence globale exemple rooter, model et chemin de vue
 * c'est aussi dans ce fichié qu'on définir les élément de migration
 */

use Framework\Router;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use function \DI\{factory, create, get};
use Framework\Renderer\RendererInterface;

use Framework\Router\RouterTwigExtension;
use Framework\Renderer\TwigRendererFactory;
use Framework\Twig\FlashExtension;
use Framework\Sessions\PHPSession;
use Framework\Sessions\SessionInterface;
use Framework\Twig\PagerFantaExtension;
use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'monsupersite',
    'views.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        get(RouterTwigExtension::class),
        get(PagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class),
        get(FlashExtension::class)
    ],
    SessionInterface::class => create(PHPSession::class),
    Router::class => create(),
    RendererInterface::class => factory(TwigRendererFactory::class), //on permet a notre configuration de ne pas dépendre de twigrender
    \PDO::class => function (ContainerInterface $c) {
        return new PDO(
            'mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name'),

            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];
