<?php

namespace Remils\Rufy\Support\Event;

use Remils\Rufy\Bus\Event;
use Throwable;

final class ExceptionEvent implements Event
{
    public function __construct(
        protected Throwable $exception,
    ) {
    }

    public function stopPropagation(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return ExceptionEvent::class;
    }

    public function getException(): Throwable
    {
        return $this->exception;
    }
}
