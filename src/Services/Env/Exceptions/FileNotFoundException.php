<?php

namespace Remils\Rufy\Services\Env\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('File not found.', 1);
    }
}
