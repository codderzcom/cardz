<?php

namespace App\Contexts\Cards;

use App\Contexts\Cards\Application\Contracts\BlockedCardRepositoryInterface;
use App\Contexts\Cards\Application\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Application\Controllers\Consumers\CardCompletedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\CardRevokedConsumer;
use App\Contexts\Cards\Infrastructure\Persistence\BlockedCardRepository;
use App\Contexts\Cards\Infrastructure\Persistence\CardRepository;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class CardsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CardRepositoryInterface::class, CardRepository::class);
        $this->app->singleton(BlockedCardRepositoryInterface::class, BlockedCardRepository::class);
        //$this->app->singleton(CardsReportingBusInterface::class, ReportingBus::class);
        //$this->app->bind(CardsCompletedConsumer::class, CardsCompletedConsumer::class);
        //$this->app->bind(CardsRevokedConsumer::class, CardsRevokedConsumer::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(CardCompletedConsumer::class));
        $reportingBus->subscribe($this->app->make(CardRevokedConsumer::class));
    }
}
