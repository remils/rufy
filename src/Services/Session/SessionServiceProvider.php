<?php

namespace Remils\Rufy\Services\Session;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class SessionServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'session';
    }

    public function newInstance(Container $container)
    {
        return new Session('SID');
    }
}
