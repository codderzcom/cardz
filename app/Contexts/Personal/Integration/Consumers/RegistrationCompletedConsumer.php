<?php

namespace App\Contexts\Personal\Integration\Consumers;

use App\Contexts\Auth\Integration\Events\RegistrationCompleted;
use App\Contexts\Personal\Application\Commands\JoinPerson;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;

final class RegistrationCompletedConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function consumes(): array
    {
        //ToDo: коннект к другому контексту
        return [
            RegistrationCompleted::class,
        ];
    }

    public function handle(string $event): void
    {
        $payload = json_decode($event)?->payload;
        if (!is_object($payload)) {
            return;
        }
        $this->commandBus->dispatch(JoinPerson::of($payload->userId, $payload->name));
    }

}
