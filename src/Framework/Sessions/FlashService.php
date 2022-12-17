<?php

namespace Framework\Sessions;

class FlashService
{

    /**
     *
     * @var SessionInterface
     */
    private $session;

    private $sessionKey = 'flash';

    private $messages = null;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function success(string $messages)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $messages;
        $this->session->set($this->sessionKey, $flash);
    }

    public function error(string $messages)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $messages;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type): ?string
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }

        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }
        return null;
    }
}
