<?php

namespace Remils\Rufy\Support\Event;

use Remils\Rufy\Bus\Event;

final class ResponseEvent implements Event
{
    public function __construct(
        protected int $code,
        protected ?string $content,
        protected array $headers = [],
    ) {
    }

    public function stopPropagation(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return ResponseEvent::class;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
