<?php

namespace Remils\Rufy\Services\CSRF;

use Remils\Rufy\Services\Request\Request;
use Remils\Rufy\Services\Session\Session;

class CSRF
{
    protected string $tokenName;

    protected Session $sessionService;

    protected Request $requestService;

    public function __construct(Session $session, Request $request, string $tokenName)
    {
        $this->sessionService = $session;
        $this->requestService = $request;
        $this->tokenName      = $tokenName;
    }

    public function tokenName(): string
    {
        return $this->tokenName;
    }

    public function token(): string
    {
        return $this->sessionService->get($this->tokenName());
    }

    public function verify(): bool
    {
        $verifedToken = $this->token() === $this->requestService->input($this->tokenName());

        $this->sessionService->unset($this->tokenName());

        return $verifedToken;
    }

    public function generate(): self
    {
        $this->sessionService->set($this->tokenName(), $this->hash());

        return $this;
    }

    protected function hash(): string
    {
        return md5(uniqid(mt_rand(), true));
    }
}
