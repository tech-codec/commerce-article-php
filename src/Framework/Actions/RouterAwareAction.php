<?php

namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * rajoute des methode liee a l utilisation du routeur
 */
trait RouterAwareAction
{
    /**
     * renvoir une reponse de redirection
     *
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirectUri);
    }
}
