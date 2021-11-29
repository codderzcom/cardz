<?php

namespace App\Contexts\Workspaces;

use App\Contexts\Workspaces\Application\Consumers\WorkspaceAddedDomainConsumer;
use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent\KeeperRepository;
use App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class WorkspacesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceRepository::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        CommandBusInterface $commandBus,
        DomainEventBusInterface $domainEventBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(WorkspaceAppService::class));

        $domainEventBus->subscribe($this->app->make(WorkspaceAddedDomainConsumer::class));
    }
}
