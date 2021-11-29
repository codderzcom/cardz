<?php

namespace App\Contexts\Collaboration;

use App\Contexts\Collaboration\Application\Consumers\InviteAcceptedConsumer;
use App\Contexts\Collaboration\Application\Services\InviteAppService;
use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Collaboration\Application\Services\RelationAppService;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\InviteRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent\RelationRepository;
use App\Contexts\Collaboration\Infrastructure\Persistence\Virtual\KeeperRepository;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent\AddedWorkspaceReadStorage;
use App\Contexts\Collaboration\Integration\Consumers\DomainEventConsumer;
use App\Contexts\Collaboration\Integration\Consumers\WorkspacesNewWorkspaceRegisteredConsumer;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class CollaborationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);

        $this->app->singleton(InviteRepositoryInterface::class, InviteRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);

        $this->app->singleton(AddedWorkspaceReadStorageInterface::class, AddedWorkspaceReadStorage::class);
    }

    public function boot(
        IntegrationEventBusInterface $integrationEventBus,
        DomainEventBusInterface $domainEventBus,
        CommandBusInterface $commandBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(
            InviteAppService::class, KeeperAppService::class, RelationAppService::class,
        ));

        $domainEventBus->subscribe($this->app->make(DomainEventConsumer::class));
        $domainEventBus->subscribe($this->app->make(InviteAcceptedConsumer::class));

        $integrationEventBus->subscribe($this->app->make(WorkspacesNewWorkspaceRegisteredConsumer::class));
    }
}
