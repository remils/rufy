<?php

namespace Remils\Rufy\Support\Subscriber;

use ReflectionClass;
use ReflectionMethod;
use Remils\Rufy\Bus\Event;
use Remils\Rufy\Bus\Subscriber;
use Remils\Rufy\Container\Container;
use Remils\Rufy\Support\Event\RequestEvent;

final class RequestSubscriber implements Subscriber
{
    public function __construct(
        protected Container $container,
    ) {
    }

    public function getEventName(): string
    {
        return RequestEvent::class;
    }

    /**
     * @param RequestEvent $event
     */
    public function handle(Event $event): void
    {
        $routeDispatch = $this->container->get('router')->match($event->getMethod(), $event->getUrl());

        $reflectionClass = new ReflectionClass(
            $routeDispatch->getRoute()->getController()
        );

        /** @var object */
        $instance = $reflectionClass->newInstance($this->container);

        $reflectionMethod = new ReflectionMethod(
            $routeDispatch->getRoute()->getController(),
            $routeDispatch->getRoute()->getAction()
        );

        $reflectionParameters = $reflectionMethod->getParameters();

        $params      = $routeDispatch->getParams();
        $validParams = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $name = $reflectionParameter->getName();

            if (array_key_exists($name, $params)) {
                $validParams[$name] = $params[$name];
            }
        }

        $reflectionMethod->invokeArgs($instance, $validParams);
    }
}
