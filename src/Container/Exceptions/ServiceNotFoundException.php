<?php

namespace Remils\Rufy\Container\Exceptions;

use Exception;

class ServiceNotFoundException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Service %s not found in container.', $name));
    }
}
