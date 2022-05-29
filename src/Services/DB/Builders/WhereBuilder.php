<?php

namespace Remils\Rufy\Services\DB\Builders;

use Closure;
use Remils\Rufy\Services\DB\Contracts\Builder;

class WhereBuilder implements Builder
{
    protected string $query = '';

    protected array $params = [];

    public function group(Closure $callback): self
    {
        $query = new static();

        call_user_func($callback, $query);

        if ($query->getQuery()) {
            if ($this->query) {
                $this->query = sprintf('%s (%s)', $this->query, $query->getQuery());
            } else {
                $this->query = sprintf('(%s)', $query->getQuery());
            }

            $this->params = array_merge($this->params, $query->getParams());
        }

        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        if ($this->isOperator($operator)) {
            if ($this->query) {
                $this->query = sprintf('%s AND %s %s ?', $this->query, $column, $operator);
            } else {
                $this->query = sprintf('%s %s ?', $column, $operator);
            }

            $this->params[] = $value;
        }

        return $this;
    }

    public function orWhere(string $column, string $operator, $value): self
    {
        if ($this->isOperator($operator)) {
            if ($this->query) {
                $this->query = sprintf('%s OR %s %s ?', $this->query, $column, $operator);
            } else {
                $this->query = sprintf('%s %s ?', $column, $operator);
            }

            $this->params[] = $value;
        }

        return $this;
    }

    public function whereIn(string $column, array $value): self
    {
        $data = [];

        foreach ($value as $param) {
            $this->params[] = $param;
            $data[] = '?';
        }

        if ($this->query) {
            $this->query = sprintf('%s AND %s IN (%s)', $this->query, $column, join(', ', $data));
        } else {
            $this->query = sprintf('%s IN (%s)', $column, join(', ', $data));
        }

        return $this;
    }

    public function orWhereIn(string $column, array $value): self
    {
        $data = [];

        foreach ($value as $param) {
            $this->params[] = $param;
            $data[] = '?';
        }

        if ($this->query) {
            $this->query = sprintf('%s OR %s IN (%s)', $this->query, $column, join(', ', $data));
        } else {
            $this->query = sprintf('%s IN (%s)', $column, join(', ', $data));
        }

        return $this;
    }

    public function whereBetween(string $column, $min, $max): self
    {
        if ($this->query) {
            $this->query = sprintf('%s AND %s BETWEEN ? AND ?', $this->query, $column);
        } else {
            $this->query = sprintf('%s BETWEEN ? AND ?', $column);
        }

        $this->params[] = $min;
        $this->params[] = $max;

        return $this;
    }

    public function orWhereBetween(string $column, $min, $max): self
    {
        if ($this->query) {
            $this->query = sprintf('%s OR %s BETWEEN ? AND ?', $this->query, $column);
        } else {
            $this->query = sprintf('%s BETWEEN ? AND ?', $column);
        }

        $this->params[] = $min;
        $this->params[] = $max;

        return $this;
    }

    public function whereNotBetween(string $column, $min, $max): self
    {
        if ($this->query) {
            $this->query = sprintf('%s AND %s NOT BETWEEN ? AND ?', $this->query, $column);
        } else {
            $this->query = sprintf('%s NOT BETWEEN ? AND ?', $column);
        }

        $this->params[] = $min;
        $this->params[] = $max;

        return $this;
    }

    public function orWhereNotBetween(string $column, $min, $max): self
    {
        if ($this->query) {
            $this->query = sprintf('%s OR %s NOT BETWEEN ? AND ?', $this->query, $column);
        } else {
            $this->query = sprintf('%s NOT BETWEEN ? AND ?', $column);
        }

        $this->params[] = $min;
        $this->params[] = $max;

        return $this;
    }

    public function whereNotNull(string $column): self
    {
        if ($this->query) {
            $this->query = sprintf('%s AND %s IS NOT NULL', $this->query, $column);
        } else {
            $this->query = sprintf('%s IS NOT NULL', $column);
        }

        return $this;
    }

    public function orWhereNotNull(string $column): self
    {
        if ($this->query) {
            $this->query = sprintf('%s OR %s IS NOT NULL', $this->query, $column);
        } else {
            $this->query = sprintf('%s IS NOT NULL', $column);
        }

        return $this;
    }

    public function whereNull(string $column): self
    {
        if ($this->query) {
            $this->query = sprintf('%s AND %s IS NULL', $this->query, $column);
        } else {
            $this->query = sprintf('%s IS NULL', $column);
        }

        return $this;
    }

    public function orWhereNull(string $column): self
    {
        if ($this->query) {
            $this->query = sprintf('%s OR %s IS NULL', $this->query, $column);
        } else {
            $this->query = sprintf('%s IS NULL', $column);
        }

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

    protected function isOperator(string $operator): bool
    {
        return in_array($operator, ['=', '!=', '>', '>=', '<=', '<>', 'LIKE']);
    }
}
