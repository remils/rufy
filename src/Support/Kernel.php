<?php

namespace Remils\Rufy\Support;

use ReflectionClass;
use Remils\Rufy\Bus\Bus;
use Remils\Rufy\Bus\Event;
use Remils\Rufy\Bus\Subscriber;
use Remils\Rufy\Config\Config;
use Remils\Rufy\Container\Container;
use Remils\Rufy\Database\Connection;
use Remils\Rufy\Router\Router;
use Remils\Rufy\Support\Event\ExceptionEvent;
use Remils\Rufy\Support\Subscriber\RequestSubscriber;
use Remils\Rufy\Support\Subscriber\ResponseSubscriber;
use Remils\Rufy\Support\Subscriber\ViewSubscriber;
use Remils\Rufy\View\View;
use Throwable;

abstract class Kernel
{
    abstract protected function getRootPath(): string;

    abstract protected function getConfigPath(): string;

    abstract protected function getTemplatesPath(): string;

    abstract protected function registerProviders(Container $container): void;

    abstract protected function registerConnections(Connection $connection, Config $config): void;

    abstract protected function registerRoutes(Router $router): void;

    protected function registerSubscribers(): array
    {
        return [
            RequestSubscriber::class,
            ViewSubscriber::class,
            ResponseSubscriber::class,
        ];
    }

    public function handle(Event $event): void
    {
        $container = new Container();
        $bus       = new Bus();

        try {
            foreach ($this->registerSubscribers() as $subscriber) {
                $reflectionClass = new ReflectionClass($subscriber);

                if (!$reflectionClass->implementsInterface(Subscriber::class)) {
                    continue;
                }

                if ($reflectionClass->hasMethod('__construct')) {
                    $instance = $reflectionClass->newInstance($container);
                } else {
                    $instance = $reflectionClass->newInstanceWithoutConstructor();
                }

                $bus->subscriber($instance);
            }

            $container->bind('bus', $bus);
            $container->bind('connection', new Connection());
            $container->bind('root_path', $this->getRootPath());
            $container->bind('config', new Config($this->getConfigPath()));
            $container->bind('view', new View($this->getTemplatesPath()));
            $container->bind('router', new Router());

            $this->registerConnections(
                $container->get('connection'),
                $container->get('config')
            );

            $this->registerProviders($container);

            $this->registerRoutes(
                $container->get('router')
            );

            $bus->dispatch($event);
        } catch (Throwable $exception) {
            $event = new ExceptionEvent($exception);

            throw $exception;

            $bus->dispatch($event);
        }
    }
}
