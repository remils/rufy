<?php

namespace Remils\Rufy\Services\Request;

class Request
{
    protected array $server;

    protected array $query;

    protected array $input;

    protected array $file;

    public function __construct()
    {
        $this->server  = $_SERVER ?? [];
        $this->query   = $_GET ?? [];
        $this->input   = $_POST ?? [];
        $this->file    = $_FILES ?? [];
    }

    public function url(): string
    {
        list($url) = explode('?', $this->server('REQUEST_URI'));

        return $url;
    }

    public function method(): string
    {
        return mb_strtoupper($this->server('REQUEST_METHOD'));
    }

    public function referer(): string
    {
        return $this->server('HTTP_REFERER');
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === mb_strtoupper($method);
    }

    public function userAgent(): string
    {
        return $this->server('HTTP_USER_AGENT');
    }

    public function ip(): string
    {
        return $this->server('REMOTE_ADDR');
    }

    public function server(string $name, $default = null)
    {
        return $this->get($this->server, $name, $default);
    }

    public function hasServer(string $name): bool
    {
        return $this->has($name, $this->server);
    }

    public function query(string $name, $default = null)
    {
        return $this->get($this->query, $name, $default);
    }

    public function hasQuery(string $name): bool
    {
        return $this->has($name, $this->query);
    }

    public function input(string $name, $default = null)
    {
        return $this->get($this->input, $name, $default);
    }

    public function hasInput(string $name): bool
    {
        return $this->has($name, $this->input);
    }

    public function file(string $name, $default = null)
    {
        return $this->get($this->file, $name, $default);
    }

    public function hasFile(string $name): bool
    {
        return $this->has($name, $this->file);
    }

    protected function get(array $data, string $name, $default)
    {
        if ($this->has($name, $data)) {
            return $data[$name];
        }

        return $default;
    }

    protected function has(string $name, array $data): bool
    {
        return array_key_exists($name, $data);
    }
}
