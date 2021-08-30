<?php

namespace App\Contexts\MobileAppBack;

use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultFactoryInterface;
use App\Contexts\MobileAppBack\Application\Services\Shared\ApplicationServiceResultFactory;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Infrastructure\Messaging\ReportingBus;
use Illuminate\Support\ServiceProvider;

class MobileAppBackProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ReportingBusInterface::class, ReportingBus::class);
        $this->app->singleton(ApplicationServiceResultFactoryInterface::class, ApplicationServiceResultFactory::class);
    }
}
