<?php

namespace Remils\Rufy\Bus;

final class Bus
{
    /** @var array<Subscriber> */
    protected array $subscribers = [];

    public function subscriber(Subscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function dispatch(Event $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->getEventName() === $event->getName()) {
                $subscriber->handle($event);

                if ($event->stopPropagation()) {
                    break;
                }
            }
        }
    }
}
