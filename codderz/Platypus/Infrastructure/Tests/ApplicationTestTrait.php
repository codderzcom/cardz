<?php

namespace Codderz\Platypus\Infrastructure\Tests;

use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventBusInterface;
use Codderz\Platypus\Contracts\Queries\QueryBusInterface;
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

    protected function eventBus(): EventBusInterface
    {
        return $this->app->make(EventBusInterface::class);
    }

    protected function assertEvent($eventIdentifier): void
    {
        $this->assertTrue($this->eventBus()->hasRecordedEvent($eventIdentifier), 'Missing event');
    }
}
