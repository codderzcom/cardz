<?php

namespace Cardz\Core\Plans;

use Cardz\Core\Plans\Application\Consumers\PlanDomainEventsConsumer;
use Cardz\Core\Plans\Application\Consumers\RequirementChangedDomainEventsConsumer;
use Cardz\Core\Plans\Application\Services\PlanAppService;
use Cardz\Core\Plans\Application\Services\RequirementAppService;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Messaging\DomainEventBus;
use Cardz\Core\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Core\Plans\Infrastructure\Persistence\Eloquent\PlanRepository;
use Cardz\Core\Plans\Infrastructure\Persistence\Eloquent\RequirementRepository;
use Cardz\Core\Plans\Infrastructure\Persistence\Eloquent\WorkspaceRepository;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadRequirementStorageInterface;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Eloquent\ReadPlanStorage;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Eloquent\ReadRequirementStorage;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
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
        CommandBusInterface $commandBus,
        DomainEventBusInterface $domainEventBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(
            PlanAppService::class, RequirementAppService::class
        ));

        $domainEventBus->subscribe($this->app->make(PlanDomainEventsConsumer::class));
        $domainEventBus->subscribe($this->app->make(RequirementChangedDomainEventsConsumer::class));
    }
}
