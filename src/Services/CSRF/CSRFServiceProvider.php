<?php

namespace Remils\Rufy\Services\CSRF;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class CSRFServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'csrf';
    }

    public function newInstance(Container $container)
    {
        return new CSRF($container->get('session'), $container->get('request'), 'csrf_token');
    }
}
