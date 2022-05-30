<?php

namespace Remils\Rufy\Services\Router\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct(string $method, string $url)
    {
        parent::__construct(sprintf('Route %s:%s not found.', $method, $url));
    }
}
