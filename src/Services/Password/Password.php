<?php

namespace Remils\Rufy\Services\Password;

class Password
{
    protected string $algo;

    protected array $options;

    public function __construct(string $algo, array $options = [])
    {
        $this->algo    = $algo;
        $this->options = $options;
    }

    public function hash(string $password): string
    {
        return password_hash($password, $this->algo, $this->options);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
