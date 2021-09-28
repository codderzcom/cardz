<?php

namespace App\Contexts\Auth;

use App\Contexts\Auth\Application\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Application\Controllers\Consumers\TokenGeneratedConsumer;
use App\Contexts\Auth\Application\Controllers\Consumers\UserNameProvidedConsumer;
use App\Contexts\Auth\Infrastructure\Persistence\UserRepository;
use App\Shared\Contracts\ReportingBusInterface;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(ReportingBusInterface $reportingBus)
    {
        $reportingBus->subscribe($this->app->make(UserNameProvidedConsumer::class));
        $reportingBus->subscribe($this->app->make(TokenGeneratedConsumer::class));
    }
}
