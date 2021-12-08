<?php

namespace Cardz\Core\Workspaces\Tests\Feature;

use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Tests\Support\Mocks\KeeperInMemoryRepository;
use Cardz\Core\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;

trait WorkspacesTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(KeeperRepositoryInterface::class, KeeperInMemoryRepository::class);
    }

    protected function getWorkspaceRepository(): WorkspaceRepositoryInterface
    {
        return $this->app->make(WorkspaceRepositoryInterface::class);
    }

    protected function getKeeperRepository(): KeeperRepositoryInterface
    {
        return $this->app->make(KeeperRepositoryInterface::class);
    }

}
