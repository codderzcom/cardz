<?php

namespace Cardz\Core\Personal\Integration\Consumers;

use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Generic\Identity\Integration\Events\RegistrationCompleted;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;

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
