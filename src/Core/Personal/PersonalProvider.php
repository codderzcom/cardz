<?php

namespace Cardz\Core\Personal;

use Cardz\Core\Personal\Application\Services\PersonAppService;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Infrastructure\Messaging\DomainEventBus;
use Cardz\Core\Personal\Infrastructure\Messaging\DomainEventBusInterface;
use Cardz\Core\Personal\Infrastructure\Persistence\Eloquent\PersonRepository;
use Cardz\Core\Personal\Integration\Consumers\RegistrationCompletedConsumer;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;
use Codderz\Platypus\Infrastructure\CommandHandling\LaravelHandlerGenerator;
use Illuminate\Support\ServiceProvider;

class PersonalProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->singleton(DomainEventBusInterface::class, DomainEventBus::class);
    }

    public function boot(
        CommandBusInterface $commandBus,
        IntegrationEventBusInterface $integrationEventBus,
    ) {
        $commandBus->registerProvider(LaravelHandlerGenerator::of(PersonAppService::class));
        $integrationEventBus->subscribe($this->app->make(RegistrationCompletedConsumer::class));
    }
}
