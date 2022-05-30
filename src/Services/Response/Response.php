<?php

namespace Remils\Rufy\Services\Response;

class Response
{
    public function contentType(string $contentType): self
    {
        header(sprintf('Content-Type: %s', $contentType));

        return $this;
    }

    public function status(int $status): self
    {
        http_response_code($status);

        return $this;
    }

    public function text($data): self
    {
        echo $data;

        return $this;
    }

    public function dump($data): void
    {
        $this->status(500);
        $this->text('<pre>');
        $this->text(var_dump($data));
        $this->text('</pre>');
    }

    public function json($data, int $status = 200): void
    {
        $this->status($status);
        $this->contentType('application/json; charset=utf-8');
        $this->text(json_encode($data));
    }

    public function noContent(): void
    {
        $this->status(204);
    }

    public function redirect(string $url): void
    {
        $this->status(302);

        header(sprintf('Location: %s', $url));
    }
}
