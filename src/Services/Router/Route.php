<?php

namespace Remils\Rufy\Services\Router;

class Route
{
    protected string $method;

    protected string $pattern;

    protected string $controller;

    protected string $action;

    protected array $patterns = [];

    protected array $middlewares = [];

    public function __construct(string $method, string $pattern, string $controller, string $action)
    {
        $this->method     = mb_strtoupper($method);
        $this->pattern    = $pattern;
        $this->controller = $controller;
        $this->action     = $action;
    }

    public function where(string $name, string $pattern): self
    {
        $this->patterns[$name] = $pattern;

        return $this;
    }

    public function patterns(): array
    {
        return $this->patterns;
    }

    public function middleware(string $name): self
    {
        $this->middlewares[] = $name;

        return $this;
    }

    public function middlewares(): array
    {
        return $this->middlewares;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    public function controller(): string
    {
        return $this->controller;
    }

    public function action(): string
    {
        return $this->action;
    }
}
