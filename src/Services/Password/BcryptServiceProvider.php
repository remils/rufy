<?php

namespace Remils\Rufy\Services\Password;

use Remils\Rufy\Container\Contracts\Container;
use Remils\Rufy\Container\Contracts\ServiceProvider;

class BcryptServiceProvider implements ServiceProvider
{
    public function name(): string
    {
        return 'bcrypt';
    }

    public function newInstance(Container $container)
    {
        return new Password(PASSWORD_BCRYPT);
    }
}
