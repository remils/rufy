<?php

namespace Remils\Rufy\Services\DB;

use Remils\Rufy\Services\DB\Exceptions\ConnectNotFoundException;

class DB
{
    protected array $connects = [];

    public function connect(string $name): DBConnect
    {
        if (array_key_exists($name, $this->connects)) {
            return $this->connects[$name];
        }

        throw new ConnectNotFoundException($name);
    }

    public function setConnect(string $name, DBConnect $connect): self
    {
        $this->connects[$name] = $connect;

        return $this;
    }
}
