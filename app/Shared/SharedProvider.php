<?php

namespace App\Shared;

use App\Shared\Contracts\PolicyEngineInterface;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Infrastructure\Messaging\ReportingBus;
use App\Shared\Infrastructure\Policy\PolicyEngine;
use App\Shared\Infrastructure\Support\ServiceResultFactory;
use Illuminate\Support\ServiceProvider;

class SharedProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportingBusInterface::class, ReportingBus::class);
        $this->app->singleton(ServiceResultFactoryInterface::class, ServiceResultFactory::class);
        $this->app->singleton(PolicyEngineInterface::class, PolicyEngine::class);
    }
}
