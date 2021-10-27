<?php

namespace App\Shared\Contracts\Queries;

interface QueryExecutorProviderInterface
{
    /**
     * @return array<string, callable>
     */
    public function getExecutors(): array;
}
