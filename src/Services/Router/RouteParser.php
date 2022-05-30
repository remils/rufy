<?php

namespace Remils\Rufy\Services\Router;

use Remils\Rufy\Services\Request\Request;

class RouteParser
{
    protected Request $request;

    protected Route $route;

    public function __construct(Request $request, Route $route)
    {
        $this->request    = $request;
        $this->route      = $route;
    }

    public function parse()
    {
        if ($this->request->isMethod($this->route->method())) {
            $pattern = $this->route->pattern();

            foreach ($this->route->patterns() as $name => $value) {
                $pattern = join(sprintf('(%s?)', $value), explode(sprintf('{%s}', $name), $pattern));
            }

            $pattern = sprintf('#^%s$#i', $pattern);

            if (preg_match($pattern, $this->request->url(), $args)) {
                array_shift($args);

                return new RouteParse($this->route, $args);
            }
        }

        return null;
    }
}
