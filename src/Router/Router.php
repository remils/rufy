<?php

namespace Remils\Rufy\Router;

final class Router
{
    /** @var array<Route> */
    protected array $routes = [];

    public function route(
        string $method,
        string $url,
        string $controller,
        string $action,
        array $patterns = []
    ): Router {
        $this->routes[] = new Route($method, $url, $controller, $action, $patterns);

        return $this;
    }

    public function match(string $method, string $url): RouteDispatch
    {
        foreach ($this->routes as $route) {
            if ($route->getMethod() === $method) {
                $keys = array_keys($route->getPatterns());

                $pattern = str_replace(
                    array_map(
                        fn (string $key) => sprintf('\{%s\}', $key),
                        $keys
                    ),
                    array_values($route->getPatterns()),
                    sprintf('#^%s$#i', preg_quote($route->getUrl()))
                );

                if (preg_match($pattern, $url, $params)) {
                    array_shift($params);

                    $validParams = [];

                    foreach ($keys as $index => $key) {
                        $validParams[$key] = $params[$index];
                    }

                    return new RouteDispatch($route, $validParams);
                }
            }
        }

        throw new RouterException('Route not found.');
    }
}
