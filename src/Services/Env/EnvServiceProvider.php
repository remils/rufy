<?php

namespace Remils\Rufy\Services\Env;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class EnvServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'env';
    }

    public function newInstance(Container $container)
    {
        return new Env();
    }
}
