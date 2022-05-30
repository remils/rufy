<?php

namespace Remils\Rufy\Services\DB\Exceptions;

use Exception;

class ConnectNotFoundException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Connect %s not found.', $name));
    }
}
