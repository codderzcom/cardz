<?php

namespace App\Contexts\Cards;

use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;
use Illuminate\Support\ServiceProvider;

class CardsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportingBus::class, ReportingBus::class);
    }
}
