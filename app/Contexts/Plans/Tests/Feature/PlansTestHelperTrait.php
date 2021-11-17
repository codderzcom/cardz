<?php

namespace App\Contexts\Plans\Tests\Feature;

use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Plans\Tests\Support\Mocks\PlanInMemoryRepository;
use App\Contexts\Plans\Tests\Support\Mocks\WorkspaceInMemoryRepository;

trait PlansTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanInMemoryRepository::class);
    }

    protected function getPlanRepository(): PlanRepositoryInterface
    {
        return $this->app->make(PlanRepositoryInterface::class);
    }
}
