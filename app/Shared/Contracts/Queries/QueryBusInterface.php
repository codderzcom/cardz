<?php

namespace App\Shared\Contracts\Queries;

interface QueryBusInterface
{
    public function execute(QueryInterface $query);

    public function registerExecutor(string $name, callable $executor): void;

    public function registerProvider(QueryExecutorProviderInterface $provider): void;
}
