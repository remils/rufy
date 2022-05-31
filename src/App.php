<?php

namespace Remils\Rufy;

use Remils\Rufy\Container\Container;

class App
{
    protected Container $container;

    protected array $serviceProviders = [
        \Remils\Rufy\Services\Cookie\CookieServiceProvider::class,
        \Remils\Rufy\Services\Session\SessionServiceProvider::class,
        \Remils\Rufy\Services\Request\RequestServiceProvider::class,
        \Remils\Rufy\Services\CSRF\CSRFServiceProvider::class,
        \Remils\Rufy\Services\DB\DBServiceProvider::class,
        \Remils\Rufy\Services\Env\EnvServiceProvider::class,
        \Remils\Rufy\Services\Middleware\MiddlewareServiceProvider::class,
        \Remils\Rufy\Services\Password\BcryptServiceProvider::class,
        \Remils\Rufy\Services\Response\ResponseServiceProvider::class,
        \Remils\Rufy\Services\Router\RouterServiceProvider::class,
    ];

    public function __construct(array $serviceProviders = [])
    {
        $this->container = new Container(array_merge($this->serviceProviders, $serviceProviders));
    }

    public function get(string $name)
    {
        return $this->container->get($name);
    }

    public function handle()
    {
        $this->get('middleware')->set('csrf', \Remils\Rufy\Middlewares\CSRFMiddleware::class);

        return $this->get('router')->handle($this->container);
    }
}
