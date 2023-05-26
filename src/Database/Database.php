<?php

namespace Remils\Rufy\Database;

use PDO;
use ReflectionFunction;
use Throwable;

final class Database
{
    protected PDO $pdo;

    public function __construct(string $dsn, string $username = null, string $password = null)
    {
        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execute(string $query, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute($params);
    }

    public function fetch(string $entity, string $query, array $params = []): ?object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $entity);

        return $stmt->fetch() ?? null;
    }

    public function fetchAll(string $entity, string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $entity);

        return $stmt->fetchAll();
    }

    public function fetchColumn(string $query, array $params = [], int $column = 0): mixed
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchColumn($column);
    }

    public function transaction(callable $callback, ...$args): mixed
    {
        try {
            $this->pdo->beginTransaction();

            $reflectionFunction = new ReflectionFunction($callback);
            $result = $reflectionFunction->invoke($this, ...$args);

            $this->pdo->commit();

            return $result;
        } catch (Throwable $exception) {
            $this->pdo->rollBack();

            throw $exception;
        }
    }
}
