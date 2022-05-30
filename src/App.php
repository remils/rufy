<?php

namespace Remils\Rufy;

use Remils\Rufy\Container\Container;
use Remils\Rufy\Services\Middleware\Middleware;
use Remils\Rufy\Services\Router\Router;

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

    public function __construct(...$serviceProviders)
    {
        $this->container = new Container(array_merge($this->serviceProviders, $serviceProviders));
    }

    public function middleware(): Middleware
    {
        return $this->container->get('middleware');
    }

    public function router(): Router
    {
        return $this->container->get('router');
    }

    public function handle()
    {
        $this->middleware()->set('csrf', \Remils\Rufy\Middlewares\CSRFMiddleware::class);

        return $this->router()->handle($this->container);
    }
}
