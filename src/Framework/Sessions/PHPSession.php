<?php

namespace Framework\Sessions;

class PHPSession implements SessionInterface
{

    /**
     * Assure que la session est démarrée
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * recupere une information en session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
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
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }


    /**
     * supprime une clef en session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}
