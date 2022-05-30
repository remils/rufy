<?php

namespace Remils\Rufy\Services\Middleware;

use ReflectionClass;
use Remils\Rufy\Services\Middleware\Contracts\Middleware as MiddlewareContract;
use Remils\Rufy\Services\Middleware\Exceptions\MiddlewareNotFoundException;

class Middleware
{
    protected $middlewares = [];

    public function get(string $name): MiddlewareContract
    {
        if (array_key_exists($name, $this->middlewares)) {
            return $this->middlewares[$name];
        }

        throw new MiddlewareNotFoundException($name);
    }

    public function set(string $name, string $middleware): self
    {
        $this->middlewares[$name] = (new ReflectionClass($middleware))->newInstance();

        return $this;
    }
}
