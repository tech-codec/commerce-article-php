<?php

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Psr\Container\ContainerInterface;
use Framework\Router\RouterTwigExtension;

/**
 * cette classe est utilisée pour être appeler comme un callable ou une closure fontion
 * grace a la methode globale __invoke et elle a pour role de créée un instance de twigrender
 */
class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $viewPath = $container->get('views.path');
        $loader = new FilesystemLoader($viewPath);
        $twig = new Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }
        return new TwigRenderer($loader, $twig);
    }
}
