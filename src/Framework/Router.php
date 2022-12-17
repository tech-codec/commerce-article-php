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
    public function get(string $path, $callback, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callback, ['GET'], $name));
    }


    /**
     * la méthode qui permet D'd'ajouter une route en post a notre system
     *
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public function post(string $path, $callback, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callback, ['POST'], $name));
    }


    /**
     * la méthode qui permet D'd'ajouter une route en post a notre system
     *
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public function delete(string $path, $callback, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callback, ['DELETE'], $name));
    }

    /**
     * Génère les routes du crud
     *
     * @param string $prefixPath
     * @param $callable
     * @param string $prefixName
     * @return void
     */
    public function crud(string $prefixPath, $callable, ?string $prefixName = null)
    {
        $this->get("$prefixPath", $callable, "$prefixName.index");
        $this->get("$prefixPath/new", $callable, "$prefixName.create");
        $this->post("$prefixPath/new", $callable);
        $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
        $this->post("$prefixPath/{id:\d+}", $callable);
        $this->delete("$prefixPath/{id:\d+}", $callable, "$prefixName.delete");
        //$router->deletet("$prefix/posts/{id:\d+}", AdminBlogAction::class);
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

    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
