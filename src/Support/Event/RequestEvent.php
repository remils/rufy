<?php

namespace Remils\Rufy\Support\Event;

use Remils\Rufy\Bus\Event;

final class RequestEvent implements Event
{
    protected string $method;
    protected string $url;

    public function __construct()
    {
        list($url) = explode('?', $_SERVER['REQUEST_URI']);

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url    = $url;
    }

    public function stopPropagation(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return RequestEvent::class;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
