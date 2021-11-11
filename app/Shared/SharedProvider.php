<?php

namespace App\Shared;

use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use App\Shared\Infrastructure\CommandHandling\QueuedSyncCommandBus;
use App\Shared\Infrastructure\Messaging\EventBus;
use App\Shared\Infrastructure\Messaging\IntegrationEventBus;
use App\Shared\Infrastructure\Messaging\LocalSyncMessageBroker;
use App\Shared\Infrastructure\Messaging\RabbitMQMessageBroker;
use App\Shared\Infrastructure\QueryHandling\SyncQueryBus;
use Illuminate\Support\ServiceProvider;

class SharedProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommandBusInterface::class, QueuedSyncCommandBus::class);
        $this->app->singleton(QueryBusInterface::class, SyncQueryBus::class);

        $this->app->singleton(EventBusInterface::class, fn() => new EventBus($this->app->make(LocalSyncMessageBroker::class)));
        $this->app->singleton(IntegrationEventBusInterface::class, fn() => new IntegrationEventBus($this->app->make(RabbitMQMessageBroker::class)));
    }
}
