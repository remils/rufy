<?php

namespace Remils\Rufy\Middlewares;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Services\CSRF\CSRF;
use Remils\Rufy\Services\Middleware\Contracts\Middleware;
use Remils\Rufy\Services\Response\Response;

class CSRFMiddleware implements Middleware
{
    public function handle(Container $container, ...$args)
    {
        /** @var Response */
        $response = $container->get('response');

        /** @var CSRF */
        $csrf = $container->get('csrf');

        if (!$csrf->verify()) {
            $response->status(419);
            exit;
        }
    }
}
