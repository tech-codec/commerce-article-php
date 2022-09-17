<?php

/**
 * fichier de configuration de nos différents dépendence globale exemple rooter, model et chemin de vue
 * c'est aussi dans ce fichié qu'on définir les élément de migration
 */

use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Router\RouterTwigExtension;

use function \DI\{factory, create, get};

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'monsupersite',
    'views.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [get(RouterTwigExtension::class)],
    Router::class => create(),
    RendererInterface::class => factory(TwigRendererFactory::class) //on permet a notre configuration de ne pas dépendre de twigrender
];
