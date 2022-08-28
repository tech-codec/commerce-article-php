<?php

namespace Framework\Router;

/**
 * représente la route de notre systeme
 */
class Route
{

    /**
     * le nom de la route
     *
     * @var string
     */
    private string $name;

    /**
     * la methode de la route a appeller(celui d'un controller)
     *
     * @var
     */
    private $callback;

    /**
     * le tableau des paramètres de la route
     *
     * @var array
     */
    private array $params;

    public function __construct(string $name, $callback, array $params)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }


    /**
     * retourne le nom de la route
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * retourne la methode du controller qui est lié a la route
     *
     * @return
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Retourne les paramettre de la route
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
