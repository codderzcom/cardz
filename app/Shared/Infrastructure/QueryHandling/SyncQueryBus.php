<?php

namespace App\Shared\Infrastructure\QueryHandling;

use App\Shared\Contracts\Queries\QueryBusInterface;
use App\Shared\Contracts\Queries\QueryExecutorProviderInterface;
use App\Shared\Contracts\Queries\QueryInterface;

class SyncQueryBus implements QueryBusInterface
{
    protected array $executors = [];

    public function execute(QueryInterface $query)
    {
        $name = $query::class;
        return array_key_exists($name, $this->executors) ? $this->executors[$name]($query) : null;
    }

    public function registerExecutor(string $name, callable $executor): void
    {
        $this->executors[$name] = $executor;
    }

    public function registerProvider(QueryExecutorProviderInterface $provider): void
    {
        $this->executors = array_merge($this->executors, $provider->getExecutors());
    }

}
