<?php

namespace Remils\Rufy\Container\Contracts;

interface Container
{
    public function get(string $name);

    public function has(string $name): bool;
}
