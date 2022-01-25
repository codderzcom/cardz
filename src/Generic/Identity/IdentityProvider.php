<?php

namespace Cardz\Generic\Identity;

use Cardz\Generic\Identity\Application\Consumers\TokenAssignedConsumer;
use Cardz\Generic\Identity\Application\Consumers\UserProfileProvidedConsumer;
use Cardz\Generic\Identity\Application\Consumers\UserRegistrationInitiatedConsumer;
use Cardz\Generic\Identity\Application\Services\TokenAppService;
use Cardz\Generic\Identity\Application\Services\UserAppService;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Infrastructure\Messaging\DomainEventBus;
use Cardz\Generic\Identity\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Generic\Identity\Infrastructure\Persistence\Eloquent\UserRepository;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Queries\QueryBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Codderz\Platypus\Infrastructure\QueryHandling\LaravelExecutorGenerator;
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
        $commandBus->registerProvider(LaravelHandlerGenerator::of(TokenAppService::class));
        $queryBus->registerProvider(LaravelExecutorGenerator::of(TokenAppService::class));

        $domainEventBus->subscribe($this->app->make(TokenAssignedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserProfileProvidedConsumer::class));
        $domainEventBus->subscribe($this->app->make(UserRegistrationInitiatedConsumer::class));
    }
}
