<?php

namespace Remils\Rufy\Services\Response;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class ResponseServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'response';
    }

    public function newInstance(Container $container)
    {
        return new Response();
    }
}
