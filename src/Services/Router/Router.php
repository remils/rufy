<?php

namespace Remils\Rufy\Services\Router;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Services\Middleware\Middleware;
use Remils\Rufy\Services\Request\Request;
use Remils\Rufy\Services\Router\Exceptions\RouteNotFoundException;

class Router
{
    protected Request $request;

    protected Middleware $middleware;

    protected array $routes = [];

    public function __construct(Request $request, Middleware $middleware)
    {
        $this->request    = $request;
        $this->middleware = $middleware;
    }

    public function route(string $method, string $pattern, string $controller, string $action): Route
    {
        $route = new Route($method, $pattern, $controller, $action);

        $this->routes[] = $route;

        return $route;
    }

    public function handle(Container $container)
    {
        foreach ($this->routes as $route) {
            $parser = new RouteParser($this->request, $route);

            $routeParse = $parser->parse();

            if ($routeParse) {
                foreach ($routeParse->route()->middlewares() as $name) {
                    $this->middleware->get($name)->handle($container, ...$routeParse->args());
                }

                return (new RouteDispatch(
                    $routeParse->route()->controller(),
                    $routeParse->route()->action(),
                    $routeParse->args()
                ))->handle($container);
            }
        }

        throw new RouteNotFoundException($this->request->method(), $this->request->url());
    }
}
