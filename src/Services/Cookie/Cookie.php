<?php

namespace Remils\Rufy\Services\Cookie;

class Cookie
{
    public function get(string $name, $default = null)
    {
        if ($this->has($name)) {
            return $_COOKIE[$name];
        }

        return $default;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $_COOKIE);
    }

    public function set(string $name, $value, $expired = 0): self
    {
        setcookie($name, $value, $expired);

        return $this;
    }

    public function unset(string $name): self
    {
        return $this->set($name, "", time() - 3600);
    }
}
