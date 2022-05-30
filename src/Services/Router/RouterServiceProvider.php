<?php

namespace Remils\Rufy\Services\Router;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class RouterServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'router';
    }

    public function newInstance(Container $container)
    {
        return new Router($container->get('request'), $container->get('middleware'));
    }
}
