<?php

namespace Framework\Sessions;

class ArraySession implements SessionInterface
{
    private $session = [];

    /**
     * recupere une information en session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $this->session[$key];
        }
        return $default;
    }

    /**
     * Ajoute une information en session
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value): void
    {

        $this->session[$key] = $value;
    }


    /**
     * supprime une clef en session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        unset($this->session[$key]);
    }
}
