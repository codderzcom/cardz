<?php

namespace App\Contexts\Workspaces\Tests\Feature;

use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Workspaces\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Workspaces\Tests\Support\Mocks\KeeperInMemoryRepository;
use App\Contexts\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;
use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Infrastructure\CommandHandling\SimpleAutoCommandHandlerProvider;
use App\Shared\Infrastructure\Tests\TestEventBus;
use App\Shared\Infrastructure\Tests\TestMessageBroker;

trait WorkspacesTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperInMemoryRepository::class);
        $this->app->singleton(EventBusInterface::class, fn() => new TestEventBus($this->app->make(TestMessageBroker::class)));

        $this->app->singleton(DomainEventBusInterface::class, fn() => new DomainEventBus($this->app->make(EventBusInterface::class)));

        $this->commandBus()->registerProvider(SimpleAutoCommandHandlerProvider::parse(
            $this->app->make(WorkspaceAppService::class)
        ));
    }

    protected function getWorkspaceRepository(): WorkspaceRepositoryInterface
    {
        return $this->app->make(WorkspaceRepositoryInterface::class);
    }

}
