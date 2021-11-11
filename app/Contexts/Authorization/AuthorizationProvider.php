<?php

namespace App\Contexts\Authorization;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Contexts\Authorization\Application\AuthorizationService;
use App\Contexts\Authorization\Infrastructure\AuthorizationBus;
use App\Shared\Infrastructure\QueryHandling\SimpleAutoQueryExecutorProvider;
use Illuminate\Support\ServiceProvider;

class AuthorizationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthorizationBusInterface::class, AuthorizationBus::class);
    }

    public function boot(
        AuthorizationBusInterface $authorizationBus,
        AuthorizationService $authorizationService,
    )
    {
        $authorizationBus->registerProvider(SimpleAutoQueryExecutorProvider::parse($authorizationService));
    }
}
