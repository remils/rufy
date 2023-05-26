<?php

namespace Remils\Rufy\Database;

final class Connection
{
    protected array $connections = [];

    public function init(string $key, Database $database): void
    {
        if ($this->has($key)) {
            throw new DatabaseException('Database "' . $key . '" already exists.');
        }

        $this->connections[$key] = $database;
    }

    public function connect(string $key): Database
    {
        if ($this->has($key)) {
            return $this->connections[$key];
        }

        throw new DatabaseException('Database "' . $key . '" not found.');
    }

    protected function has(string $key): bool
    {
        return array_key_exists($key, $this->connections);
    }
}
