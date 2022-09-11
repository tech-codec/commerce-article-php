<?php

namespace Framework;

use Exception;
use Framework\Router\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * c'est cette clesse qui es chargée de créer une instance de nos module (controller)
 */
class App
{

    /**
     * représente le conternaire t'injection des dépendences
     *
     * @var ContqinerInteface
     */
    private $container;

    /**
     * listes des modules de notre application(controller)
     *
     * @var array
     */

    private $modules = [];
    /**
     * App constructor
     * @param ContainerInterface $container
     * @param string[] $modules listes des modules à charger
     */

    public function __construct(ContainerInterface $container, array $modules = [])
    {

        $this->container  = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $router = $this->container->get(Router::class);
        $route = $router->match($request);

        if (is_null($route)) {
            return new Response(404, [], '<h1>Error 404</h1>');
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('the response is not a string or instance of responseInterface ');
        }
    }
}
