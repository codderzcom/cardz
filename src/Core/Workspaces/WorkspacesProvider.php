<?php

namespace Cardz\Core\Workspaces;

use Cardz\Core\Workspaces\Application\Consumers\WorkspaceAddedDomainConsumer;
use Cardz\Core\Workspaces\Application\Consumers\WorkspaceChangedDomainConsumer;
use Cardz\Core\Workspaces\Application\Projectors\WorkspaceChangedProjector;
use Cardz\Core\Workspaces\Application\Services\WorkspaceAppService;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Domain\ReadModel\Contracts\AddedWorkspaceStorageInterface;
use Cardz\Core\Workspaces\Infrastructure\Messaging\DomainEventBus;
use Cardz\Core\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent\KeeperRepository;
use Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Eloquent\AddedWorkspaceStorage;
use Cardz\Core\Workspaces\Integration\Consumers\KeeperRegisteredConsumer;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class WorkspacesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceRepository::class);
        $this->app->singleton(AddedWorkspaceStorageInterface::class, AddedWorkspaceStorage::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        CommandBusInterface $commandBus,
        DomainEventBusInterface $domainEventBus,
        IntegrationEventBusInterface $integrationEventBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(WorkspaceAppService::class));

        $domainEventBus->subscribe($this->app->make(WorkspaceAddedDomainConsumer::class));
        $domainEventBus->subscribe($this->app->make(WorkspaceChangedDomainConsumer::class));
        $domainEventBus->subscribe($this->app->make(WorkspaceChangedProjector::class));

        $integrationEventBus->subscribe(
            $this->app->make(KeeperRegisteredConsumer::class),
        );
    }
}
