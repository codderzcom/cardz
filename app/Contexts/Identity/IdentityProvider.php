<?php

namespace App\Contexts\Identity;

use App\Contexts\Identity\Application\Consumers\TokenAssignedConsumer;
use App\Contexts\Identity\Application\Consumers\UserProfileProvidedConsumer;
use App\Contexts\Identity\Application\Consumers\UserRegistrationInitiatedConsumer;
use App\Contexts\Identity\Application\Services\TokenAppService;
use App\Contexts\Identity\Application\Services\UserAppService;
use App\Contexts\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use App\Contexts\Identity\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Identity\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Identity\Infrastructure\Persistence\Eloquent\UserRepository;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use App\Shared\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use App\Shared\Infrastructure\QueryHandling\LaravelExecutorGenerator;
use Illuminate\Support\ServiceProvider;

class IdentityProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        DomainEventBusInterface $domainEventBus,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(UserAppService::class));
        $queryBus->registerProvider(LaravelExecutorGenerator::of(TokenAppService::class));

        $domainEventBus->subscribe($this->app->make(TokenAssignedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserProfileProvidedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserRegistrationInitiatedConsumer::class));
    }
}
