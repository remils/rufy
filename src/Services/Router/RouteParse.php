<?php

namespace Remils\Rufy\Services\Router;

class RouteParse
{
    protected Route $route;

    protected array $args;

    public function __construct(Route $route, array $args)
    {
        $this->route = $route;
        $this->args  = $args;
    }

    public function route(): Route
    {
        return $this->route;
    }

    public function args(): array
    {
        return $this->args;
    }
}
