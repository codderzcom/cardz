<?php

namespace App\Contexts\Auth;

use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Auth\Application\Controllers\Consumers\UserNameProvidedConsumer;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(UserNameProvidedConsumer::class));
    }
}
