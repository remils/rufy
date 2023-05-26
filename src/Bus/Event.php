<?php

namespace Remils\Rufy\Bus;

interface Event
{
    public function stopPropagation(): bool;

    public function getName(): string;
}
