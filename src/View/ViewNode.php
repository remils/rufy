<?php

namespace Remils\Rufy\View;

final class ViewNode
{
    protected array $nodes = [];

    protected function __construct(
        protected string $template,
        protected array $data = [],
    ) {
    }

    public static function make(string $template, array $data = []): ViewNode
    {
        return new static($template, $data);
    }

    public function assignNode(string $key, array|ViewNode $node): ViewNode
    {
        $this->nodes[$key] = $node;

        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getNodes(): array
    {
        return $this->nodes;
    }
}
