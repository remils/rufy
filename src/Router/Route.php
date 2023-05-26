<?php

namespace Remils\Rufy\Router;

final class Route
{
    public function __construct(
        protected string $method,
        protected string $url,
        protected string $controller,
        protected string $action,
        protected array $patterns = [],
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getPatterns(): array
    {
        return $this->patterns;
    }
}
