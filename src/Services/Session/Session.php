<?php

namespace Remils\Rufy\Services\Session;

class Session
{
    public function __construct(string $sessionName)
    {
        session_name($sessionName);
        session_start();
    }

    public function id(): string
    {
        return session_id();
    }

    public function get(string $name, $default = null)
    {
        if ($this->has($name)) {
            return $_SESSION[$name];
        }

        return $default;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $_SESSION);
    }

    public function set(string $name, $value): self
    {
        $_SESSION[$name] = $value;

        return $this;
    }

    public function unset(string $name): self
    {
        unset($_SESSION[$name]);

        return $this;
    }
}
