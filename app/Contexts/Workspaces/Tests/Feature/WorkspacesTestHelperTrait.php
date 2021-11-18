<?php

namespace App\Contexts\Workspaces\Tests\Feature;

use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Workspaces\Tests\Support\Mocks\KeeperInMemoryRepository;
use App\Contexts\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;

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

}
