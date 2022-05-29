<?php

namespace Remils\Rufy\Container\Contracts;

interface ServiceProvider
{
    public function name(): string;

    public function newInstance(Container $container);
}
