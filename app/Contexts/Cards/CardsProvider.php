<?php

namespace App\Contexts\Cards;

use App\Contexts\Cards\Application\Controllers\Consumers\CardsCompletedConsumer;
use App\Contexts\Cards\Application\Controllers\Consumers\CardsRevokedConsumer;
use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;
use Illuminate\Support\ServiceProvider;

class CardsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportingBus::class, ReportingBus::class);
        $this->app->bind(CardsCompletedConsumer::class, CardsCompletedConsumer::class);
        $this->app->bind(CardsRevokedConsumer::class, CardsRevokedConsumer::class);
    }

    public function boot(ReportingBus $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(CardsCompletedConsumer::class));
        $reportingBus->subscribe($this->app->make(CardsRevokedConsumer::class));
    }
}
