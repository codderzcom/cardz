<?php

namespace Cardz\Generic\Authorization;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\AuthorizationService;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Infrastructure\AuthorizationBus;
use Cardz\Generic\Authorization\Infrastructure\Persistence\Eloquent\ResourceRepository;
use Cardz\Generic\Authorization\Infrastructure\ResourceProvider;
use Cardz\Generic\Authorization\Infrastructure\ResourceProviderInterface;
use Cardz\Generic\Authorization\Integration\Projectors\CardResourceEventConsumer;
use Cardz\Generic\Authorization\Integration\Projectors\PlanResourceEventConsumer;
use Cardz\Generic\Authorization\Integration\Projectors\RelationEstablishedEventConsumer;
use Cardz\Generic\Authorization\Integration\Projectors\RelationRemovedEventConsumer;
use Cardz\Generic\Authorization\Integration\Projectors\SubjectResourceEventConsumer;
use Cardz\Generic\Authorization\Integration\Projectors\WorkspaceResourceEventConsumer;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;
use Codderz\Platypus\Infrastructure\QueryHandling\LaravelExecutorGenerator;
use Illuminate\Support\ServiceProvider;

class AuthorizationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthorizationBusInterface::class, AuthorizationBus::class);
        $this->app->singleton(ResourceRepositoryInterface::class, ResourceRepository::class);
        $this->app->singleton(ResourceProviderInterface::class, ResourceProvider::class);
    }

    public function boot(
        AuthorizationBusInterface $authorizationBus,
        IntegrationEventBusInterface $integrationEventBus,
    ) {
        $authorizationBus->registerProvider(LaravelExecutorGenerator::of(AuthorizationService::class));
        $integrationEventBus->subscribe($this->app->make(SubjectResourceEventConsumer::class));
        $integrationEventBus->subscribe($this->app->make(WorkspaceResourceEventConsumer::class));
        $integrationEventBus->subscribe($this->app->make(PlanResourceEventConsumer::class));
        $integrationEventBus->subscribe($this->app->make(CardResourceEventConsumer::class));
        $integrationEventBus->subscribe($this->app->make(RelationEstablishedEventConsumer::class));
        $integrationEventBus->subscribe($this->app->make(RelationRemovedEventConsumer::class));
    }
}
