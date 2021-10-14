<?php

namespace App\Contexts\Auth;

use App\Contexts\Auth\Application\Consumers\UserRegistrationInitiatedConsumer;
use App\Contexts\Auth\Application\Controllers\Consumers\TokenGeneratedConsumer;
use App\Contexts\Auth\Application\Controllers\Consumers\UserNameProvidedConsumer;
use App\Contexts\Auth\Application\Services\UserAppService;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Auth\Infrastructure\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Infrastructure\Persistence\Eloquent\UserRepository;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Infrastructure\CommandHandling\SimpleAutoCommandHandlerProvider;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        UserAppService $userAppService,
        DomainEventBusInterface $domainEventBus,
        CommandBusInterface $commandBus,
        ReportingBusInterface $reportingBus,
    )
    {
        $reportingBus->subscribe($this->app->make(UserNameProvidedConsumer::class));
        $reportingBus->subscribe($this->app->make(TokenGeneratedConsumer::class));

        $commandBus->registerProvider(SimpleAutoCommandHandlerProvider::parse($userAppService));
        $domainEventBus->subscribe($this->app->make(UserRegistrationInitiatedConsumer::class));
    }
}
