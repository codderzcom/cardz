<?php

namespace App\Contexts\Shared;

use App\Contexts\Shared\Contracts\PolicyEngineInterface;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Infrastructure\Messaging\ReportingBus;
use App\Contexts\Shared\Infrastructure\Policy\PolicyEngine;
use App\Contexts\Shared\Infrastructure\Support\ServiceResultFactory;
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
