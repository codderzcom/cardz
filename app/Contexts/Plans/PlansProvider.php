<?php

namespace App\Contexts\Plans;

use App\Contexts\Plans\Application\Consumers\PlanDomainEventsConsumer;
use App\Contexts\Plans\Application\Consumers\RequirementChangedDomainEventsConsumer;
use App\Contexts\Plans\Application\Services\PlanAppService;
use App\Contexts\Plans\Application\Services\RequirementAppService;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Eloquent\PlanRepository;
use App\Contexts\Plans\Infrastructure\Persistence\Eloquent\RequirementRepository;
use App\Contexts\Plans\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use App\Contexts\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use App\Contexts\Plans\Infrastructure\ReadStorage\Contracts\ReadRequirementStorageInterface;
use App\Contexts\Plans\Infrastructure\ReadStorage\Eloquent\ReadPlanStorage;
use App\Contexts\Plans\Infrastructure\ReadStorage\Eloquent\ReadRequirementStorage;
use Illuminate\Support\ServiceProvider;

class PlansProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(RequirementRepositoryInterface::class, RequirementRepository::class);
        $this->app->singleton(WorkspaceRepositoryInterface::class, WorkspaceRepository::class);
        $this->app->singleton(ReadPlanStorageInterface::class, ReadPlanStorage::class);
        $this->app->singleton(ReadRequirementStorageInterface::class, ReadRequirementStorage::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        PlanAppService $planAppService,
        RequirementAppService $requirementAppService,
        DomainEventBusInterface $domainEventBus,
    ) {
        $planAppService->registerHandlers();
        $requirementAppService->registerHandlers();
        $domainEventBus->subscribe($this->app->make(PlanDomainEventsConsumer::class));
        $domainEventBus->subscribe($this->app->make(RequirementChangedDomainEventsConsumer::class));
    }
}
