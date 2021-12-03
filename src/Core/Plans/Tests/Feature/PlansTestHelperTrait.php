<?php

namespace Cardz\Core\Plans\Tests\Feature;

use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Plans\Tests\Support\Mocks\PlanInMemoryRepository;
use Cardz\Core\Plans\Tests\Support\Mocks\RequirementInMemoryRepository;
use Cardz\Core\Plans\Tests\Support\Mocks\WorkspaceInMemoryRepository;

trait PlansTestHelperTrait
{
    protected function setupApplication(): void
    {
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceInMemoryRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanInMemoryRepository::class);
        $this->app->singleton(RequirementRepositoryInterface::class, RequirementInMemoryRepository::class);
    }

    protected function getPlanRepository(): PlanRepositoryInterface
    {
        return $this->app->make(PlanRepositoryInterface::class);
    }

    protected function getRequirementRepository(): RequirementRepositoryInterface
    {
        return $this->app->make(RequirementRepositoryInterface::class);
    }
}
