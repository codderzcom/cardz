<?php

namespace App\Contexts\Authorization;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Contexts\Authorization\Application\AuthorizationService;
use App\Contexts\Authorization\Infrastructure\AuthorizationBus;
use App\Shared\Infrastructure\QueryHandling\LaravelExecutorGenerator;
use Illuminate\Support\ServiceProvider;

class AuthorizationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthorizationBusInterface::class, AuthorizationBus::class);
    }

    public function boot(
        AuthorizationBusInterface $authorizationBus,
    ) {
        $authorizationBus->registerProvider(LaravelExecutorGenerator::of(AuthorizationService::class));
    }
}
