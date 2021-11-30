<?php

namespace Codderz\Platypus\Contracts\Queries;

interface QueryExecutorProviderInterface
{
    /**
     * @return array<string, callable>
     */
    public function getExecutors(): array;
}
