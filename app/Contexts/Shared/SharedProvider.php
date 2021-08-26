<?php

namespace App\Contexts\Shared;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Infrasctructure\Messaging\ReportingBus;
use Illuminate\Support\ServiceProvider;

class SharedProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportingBusInterface::class, ReportingBus::class);
    }
}
