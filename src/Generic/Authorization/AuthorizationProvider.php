<?php

namespace Cardz\Generic\Authorization;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\AuthorizationService;
use Cardz\Generic\Authorization\Infrastructure\AuthorizationBus;
use Codderz\Platypus\Infrastructure\QueryHandling\LaravelExecutorGenerator;
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
