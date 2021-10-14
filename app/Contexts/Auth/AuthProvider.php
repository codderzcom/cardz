<?php

namespace App\Contexts\Auth;

use App\Contexts\Auth\Application\Consumers\TokenAssignedConsumer;
use App\Contexts\Auth\Application\Consumers\UserProfileProvidedConsumer;
use App\Contexts\Auth\Application\Consumers\UserRegistrationInitiatedConsumer;
use App\Contexts\Auth\Application\Services\TokenAppService;
use App\Contexts\Auth\Application\Services\UserAppService;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Auth\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Auth\Infrastructure\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Infrastructure\Persistence\Eloquent\UserRepository;
use App\Shared\Contracts\Commands\CommandBusInterface;
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
        TokenAppService $tokenAppService,
        DomainEventBusInterface $domainEventBus,
        CommandBusInterface $commandBus,
    ) {
        $commandBus->registerProvider(SimpleAutoCommandHandlerProvider::parse($userAppService));
        $commandBus->registerProvider(SimpleAutoCommandHandlerProvider::parse($tokenAppService));

        $domainEventBus->subscribe($this->app->make(TokenAssignedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserProfileProvidedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserRegistrationInitiatedConsumer::class));
    }
}
