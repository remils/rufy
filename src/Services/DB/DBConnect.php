<?php

namespace Remils\Rufy\Services\DB;

use Closure;
use PDO;
use Remils\Rufy\Services\DB\Builders\QueryBuilder;
use Throwable;

class DBConnect
{
    protected PDO $pdo;

    public function __construct(
        string $driver,
        string $host,
        string $port,
        string $database,
        string $username,
        string $password,
        string $charset
    ) {
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            $driver,
            $host,
            $port,
            $database
        );

        $this->pdo = new PDO($dsn, $username, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->query(sprintf("SET NAMES '%s'", $charset));
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function transaction(Closure $callback): void
    {
        try {
            $this->pdo->beginTransaction();

            call_user_func($callback);

            $this->pdo->commit();
        } catch (Throwable $exception) {
            $this->pdo->rollBack();

            throw $exception;
        }
    }

    public function execute(QueryBuilder $query)
    {
        $sth = $this->pdo->prepare($query->getQuery());

        $sth->execute($query->getParams());

        return $sth;
    }

    public function fetch(QueryBuilder $query)
    {
        $sth = $this->execute($query);

        return $sth->fetch(PDO::FETCH_ASSOC) ?? null;
    }

    public function fetchAll(QueryBuilder $query)
    {
        $sth = $this->execute($query);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?? null;
    }
}
