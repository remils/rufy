<?php

namespace Remils\Rufy\Services\DB\Contracts;

interface Builder
{
    public function getQuery(): string;

    public function getParams(): array;
}
