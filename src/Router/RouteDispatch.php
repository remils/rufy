<?php

namespace Remils\Rufy\Router;

final class RouteDispatch
{
    public function __construct(
        protected Route $route,
        protected array $params,
    ) {
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
