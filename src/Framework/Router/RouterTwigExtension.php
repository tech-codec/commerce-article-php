<?php

namespace Framework\Router;

use Framework\Router;

/**
 * cette classe permet d'ajouté des méthode grace a twig en heritant de
 * AbstractExtension et ele va nous permet de gérer les lien pour
 * la navigation
 */
class RouterTwigExtension extends \Twig\Extension\AbstractExtension
{

    /**
     * intence du router
     *
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('path', [$this, 'pathFor']),
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
