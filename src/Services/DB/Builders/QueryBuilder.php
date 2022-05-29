<?php

namespace Remils\Rufy\Services\DB\Builders;

use Closure;
use Remils\Rufy\Services\DB\Contracts\Builder;

class QueryBuilder implements Builder
{
    protected string $query;

    protected array $params;

    public function __construct(string $query, array $params = [])
    {
        $this->query = $query;
        $this->params = $params;
    }

    public static function select(string $table, array $columns = ['*']): self
    {
        $query = sprintf('SELECT %s FROM %s', join(', ', $columns), $table);

        return new static($query);
    }

    public static function insert(string $table, array $data): self
    {
        $columns = [];
        $params = [];

        foreach ($data as $column => $param) {
            $columns[] = $column;
            $params[] = $param;
        }

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            join(', ', $columns),
            join(', ', array_fill(0, count($columns), '?'))
        );

        return new static($query, $params);
    }

    public static function update(string $table, array $data): self
    {
        $params = [];

        foreach ($data as $column => $param) {
            $columns[] = sprintf('%s = ?', $column);
            $params[] = $param;
        }

        $query = sprintf('UPDATE %s SET %s', $table, join(', ', $columns));

        return new static($query, $params);
    }

    public static function delete(string $table): self
    {
        $query = sprintf('DELETE FROM %s', $table);

        return new static($query);
    }

    public function where(Closure $callback): self
    {
        $query = new WhereBuilder();

        call_user_func($callback, $query);

        if ($query->getQuery()) {
            $this->query = sprintf('%s WHERE %s', $this->query, $query->getQuery());
            $this->params = array_merge($this->params, $query->getParams());
        }

        return $this;
    }

    public function limit(int $count): self
    {
        $this->query = sprintf('%s LIMIT ?', $this->query);
        $this->params[] = $count;

        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
