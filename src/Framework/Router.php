<?php

namespace Framework;

use Framework\Router\Route;
use Zend\Expressive\Router\FastRouteRouter;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * représente le routeur de notre système(le gestionaire de route)
 */
class Router
{

    /**
     * elle nous permet de recuperer les methode du FastRouteRouter
     *
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * la méthode qui permet l'ajout d'une route a notre système
     *
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public function get(string $path, $callback, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callback, ['GET'], $name));
    }

    /**
     * la méthode qui permet de retouné une route
     *
     * @param ServerRequestInterface $request
     * @return Route
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $route = $this->router->match($request);

        if ($route->isSuccess()) {
            return new Route(
                $route->getMatchedRouteName(),
                $route->getMatchedMiddleware(),
                $route->getMatchedParams()
            );
        }

        return null;
    }

    public function generateUri(string $name, array $params): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
