<?php

namespace Cardz\Support\Collaboration;

use Cardz\Support\Collaboration\Application\Consumers\InviteAcceptedConsumer;
use Cardz\Support\Collaboration\Application\Services\InviteAppService;
use Cardz\Support\Collaboration\Application\Services\KeeperAppService;
use Cardz\Support\Collaboration\Application\Services\RelationAppService;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Messaging\DomainEventBus;
use Cardz\Support\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Support\Collaboration\Infrastructure\Persistence\Eloquent\InviteRepository;
use Cardz\Support\Collaboration\Infrastructure\Persistence\Eloquent\RelationRepository;
use Cardz\Support\Collaboration\Infrastructure\Persistence\Virtual\KeeperRepository;
use Cardz\Support\Collaboration\Integration\Consumers\DomainEventConsumer;
use Cardz\Support\Collaboration\Integration\Consumers\WorkspacesNewWorkspaceRegisteredConsumer;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class CollaborationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);

        $this->app->singleton(InviteRepositoryInterface::class, InviteRepository::class);
        $this->app->singleton(RelationRepositoryInterface::class, RelationRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
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
