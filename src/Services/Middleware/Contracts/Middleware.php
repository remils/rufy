<?php

namespace Remils\Rufy\Services\Middleware\Contracts;

use Remils\Rufy\Services\Request\Request;

interface Middleware
{
    public function handle(Request $request, ...$args);
}
