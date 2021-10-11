<?php

namespace App\Contexts\Cards;

use App\Contexts\Cards\Application\Consumers\CardChangedDomainEventConsumer;
use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Cards\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Cards\Infrastructure\Persistence\Eloquent\CardRepository;
use App\Contexts\Cards\Infrastructure\Persistence\Eloquent\PlanRepository;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Infrastructure\ReadStorage\Eloquent\IssuedCardReadStorage;
use App\Contexts\Cards\Integration\Consumers\PlansRequirementDescriptionChangedConsumer;
use App\Contexts\Cards\Integration\Consumers\PlansRequirementsChangedConsumer;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use Illuminate\Support\ServiceProvider;

class CardsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CardRepositoryInterface::class, CardRepository::class);
        $this->app->singleton(IssuedCardReadStorageInterface::class, IssuedCardReadStorage::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        CardAppService $cardAppService,
        DomainEventBusInterface $domainEventBus,
        IntegrationEventBusInterface $integrationEventBus,
    ) {
        $cardAppService->registerHandlers();

        $integrationEventBus->subscribe($this->app->make(PlansRequirementsChangedConsumer::class));
        $integrationEventBus->subscribe($this->app->make(PlansRequirementDescriptionChangedConsumer::class));

        $domainEventBus->subscribe($this->app->make(CardChangedDomainEventConsumer::class));
    }
}
