<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\EventBusInterface;
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

    protected function eventBus(): TestEventBus
    {
        return $this->app->make(EventBusInterface::class);
    }

    protected function assertEvent(string $name)
    {
        if (!$this->eventBus()->hasEvent($name)) {
            $this->fail("Event $name missing");
        }
    }
}
