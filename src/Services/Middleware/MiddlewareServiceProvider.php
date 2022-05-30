<?php

namespace Remils\Rufy\Services\Middleware;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class MiddlewareServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'middleware';
    }

    public function newInstance(Container $container)
    {
        return new Middleware();
    }
}
