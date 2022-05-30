<?php

namespace Remils\Rufy\Services\Middleware\Exceptions;

use Exception;

class MiddlewareNotFoundException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Middleware %s not found.', $name));
    }
}
