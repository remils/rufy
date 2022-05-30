<?php

namespace Remils\Rufy\Services\Middleware\Contracts;

use Remils\Rufy\Container\Contracts\Container;

interface Middleware
{
    public function handle(Container $container);
}
