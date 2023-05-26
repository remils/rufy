<?php

namespace Remils\Rufy\Bus;

interface Subscriber
{
    public function getEventName(): string;

    public function handle(Event $event): void;
}
