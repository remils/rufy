<?php

namespace Remils\Rufy\Support\Event;

use Remils\Rufy\Bus\Event;
use Remils\Rufy\View\ViewNode;

final class ViewEvent implements Event
{
    public function __construct(
        protected ViewNode $node,
    ) {
    }

    public function stopPropagation(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return ViewEvent::class;
    }

    public function getNode(): ViewNode
    {
        return $this->node;
    }
}
