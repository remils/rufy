<?php

namespace Remils\Rufy\Services\DB\Exceptions;

use Exception;

class ConnectNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Connect not found.', 1);
    }
}
