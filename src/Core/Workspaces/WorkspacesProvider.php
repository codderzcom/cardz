<?php

namespace Cardz\Core\Workspaces;

use Cardz\Core\Workspaces\Application\Consumers\WorkspaceAddedDomainConsumer;
use Cardz\Core\Workspaces\Application\Consumers\WorkspaceChangedDomainConsumer;
use Cardz\Core\Workspaces\Application\Services\WorkspaceAppService;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Messaging\DomainEventBus;
use Cardz\Core\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent\KeeperRepository;
use Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Contracts\ReadWorkspaceStorageInterface;
use Cardz\Core\Workspaces\Infrastructure\ReadStorage\Eloquent\ReadWorkspaceStorage;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class WorkspacesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceRepository::class);
        $this->app->singleton(ReadWorkspaceStorageInterface::class, ReadWorkspaceStorage::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        CommandBusInterface $commandBus,
        DomainEventBusInterface $domainEventBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(WorkspaceAppService::class));

        $domainEventBus->subscribe($this->app->make(WorkspaceAddedDomainConsumer::class));
        $domainEventBus->subscribe($this->app->make(WorkspaceChangedDomainConsumer::class));
    }
}
