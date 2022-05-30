<?php

namespace Remils\Rufy\Services\Router;

use ReflectionClass;

class RouteDispatch
{
    protected string $controller;

    protected string $action;

    protected array $args;

    public function __construct(string $controller, string $action, array $args)
    {
        $this->controller = $controller;
        $this->action     = $action;
        $this->args       = $args;
    }

    public function handle()
    {
        $reflection = new ReflectionClass($this->controller);

        $controller = $reflection->newInstance();

        return call_user_func([$controller, $this->action], ...$this->args);
    }
}
