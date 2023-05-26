<?php

namespace Remils\Rufy\Support\Subscriber;

use Remils\Rufy\Bus\Event;
use Remils\Rufy\Bus\Subscriber;
use Remils\Rufy\Container\Container;
use Remils\Rufy\Support\Event\ResponseEvent;
use Remils\Rufy\Support\Event\ViewEvent;

final class ViewSubscriber implements Subscriber
{
    public function __construct(
        protected Container $container,
    ) {
    }

    public function getEventName(): string
    {
        return ViewEvent::class;
    }

    /**
     * @param ViewEvent $event
     */
    public function handle(Event $event): void
    {
        $content = $this->container->get('view')->render($event->getNode());

        $responseEvent = new ResponseEvent(
            200,
            $content,
            [
                'Content-Type: text/html; charset=UTF-8'
            ]
        );

        $this->container->get('bus')->dispatch($responseEvent);
    }
}
