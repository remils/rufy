<?php

namespace Remils\Rufy\Services\Env\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('File %s not found.', $path));
    }
}
