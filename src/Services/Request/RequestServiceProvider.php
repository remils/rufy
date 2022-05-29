<?php

namespace Remils\Rufy\Services\Request;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class RequestServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'request';
    }

    public function newInstance(Container $container)
    {
        return new Request();
    }
}
