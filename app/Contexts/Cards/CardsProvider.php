<?php

namespace App\Contexts\Cards;

use App\Contexts\Cards\Application\Contracts\BlockedCardRepositoryInterface;
use App\Contexts\Cards\Application\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Application\Controllers\Consumers\CardCompletedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\CardIssuedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\CardRevokedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\PlansRequirementDescriptionChangedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\PlansRequirementsChangedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\SatisfactionCheckRequiredConsumer;
use App\Contexts\Cards\Infrastructure\Persistence\BlockedCardRepository;
use App\Contexts\Cards\Infrastructure\Persistence\CardRepository;
use App\Contexts\Cards\Infrastructure\ReadStorage\IssuedCardReadStorage;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class CardsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CardRepositoryInterface::class, CardRepository::class);
        $this->app->singleton(BlockedCardRepositoryInterface::class, BlockedCardRepository::class);
        $this->app->singleton(IssuedCardReadStorageInterface::class, IssuedCardReadStorage::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(CardCompletedConsumer::class));
        $reportingBus->subscribe($this->app->make(CardIssuedConsumer::class));
        $reportingBus->subscribe($this->app->make(CardRevokedConsumer::class));
        $reportingBus->subscribe($this->app->make(PlansRequirementsChangedConsumer::class));
        $reportingBus->subscribe($this->app->make(PlansRequirementDescriptionChangedConsumer::class));
        $reportingBus->subscribe($this->app->make(SatisfactionCheckRequiredConsumer::class));
    }
}
