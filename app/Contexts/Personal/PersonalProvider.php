<?php

namespace App\Contexts\Personal;

use App\Contexts\Personal\Application\Services\PersonAppService;
use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use App\Contexts\Personal\Infrastructure\Messaging\DomainEventBus;
use App\Contexts\Personal\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Personal\Infrastructure\Persistence\Eloquent\PersonRepository;
use App\Contexts\Personal\Integration\Consumers\RegistrationCompletedConsumer;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Infrastructure\CommandHandling\SimpleAutoCommandHandlerProvider;
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
        PersonAppService $personAppService,
        IntegrationEventBusInterface $integrationEventBus,
    ) {
        $commandBus->registerProvider(SimpleAutoCommandHandlerProvider::parse($personAppService));
        $integrationEventBus->subscribe($this->app->make(RegistrationCompletedConsumer::class));
    }
}
