<?php

namespace Remils\Rufy\Support;

use Remils\Rufy\Bus\Event;
use Remils\Rufy\Container\Container;
use Remils\Rufy\Database\Database;
use Remils\Rufy\Support\Event\ResponseEvent;
use Remils\Rufy\Support\Event\ViewEvent;
use Remils\Rufy\View\ViewNode;

abstract class Controller
{
    public function __construct(
        private Container $container,
    ) {
    }

    protected function dependency(string $key): mixed
    {
        return $this->container->get($key);
    }

    protected function database(string $key): Database
    {
        return $this->dependency('connection')->connect($key);
    }

    protected function dispatch(Event $event): void
    {
        $this->dependency('bus')->dispatch($event);
    }

    protected function view(ViewNode $node): void
    {
        $this->dispatch(new ViewEvent($node));
    }

    protected function json(mixed $data, int $code = 200, array $headers = []): void
    {
        $headers[] = 'Content-Type: application/json';

        $event = new ResponseEvent($code, json_encode($data), $headers);

        $this->dispatch($event);
    }

    protected function redirect(string $uri): void
    {
        $headers = [];
        $headers[] = 'Location: ' . $uri;

        $event = new ResponseEvent(302, null, $headers);

        $this->dispatch($event);
    }
}
