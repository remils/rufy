<?php

namespace Remils\Rufy\Container\Exceptions;

use Exception;

class ServiceNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Service not found in container.", 1);
    }
}
