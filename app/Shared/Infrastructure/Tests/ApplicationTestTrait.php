<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait ApplicationTestTrait
{
    use RefreshDatabase;

    protected function commandBus(): CommandBusInterface
    {
        return $this->app->make(CommandBusInterface::class);
    }

    protected function queryBus(): QueryBusInterface
    {
        return $this->app->make(QueryBusInterface::class);
    }
}
