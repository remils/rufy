<?php

namespace Remils\Rufy;

use Remils\Rufy\Container\Contracts\Container;

abstract class Controller
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
