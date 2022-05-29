<?php

namespace Remils\Rufy\Services\DB;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class DBServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'db';
    }

    public function newInstance(Container $container)
    {
        return new DB();
    }
}
