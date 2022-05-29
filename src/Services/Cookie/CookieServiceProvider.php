<?php

namespace Remils\Rufy\Services\Cookie;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class CookieServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'cookie';
    }

    public function newInstance(Container $container)
    {
        return new Cookie();
    }
}
