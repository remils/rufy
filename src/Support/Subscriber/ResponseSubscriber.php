<?php

namespace Remils\Rufy\Support\Subscriber;

use Remils\Rufy\Bus\Event;
use Remils\Rufy\Bus\Subscriber;
use Remils\Rufy\Support\Event\ResponseEvent;

final class ResponseSubscriber implements Subscriber
{
    public function getEventName(): string
    {
        return ResponseEvent::class;
    }

    /**
     * @param ResponseEvent $event
     */
    public function handle(Event $event): void
    {
        http_response_code($event->getCode());

        foreach ($event->getHeaders() as $header) {
            header($header);
        }

        if ($event->getContent()) {
            echo $event->getContent();
        }
    }
}
