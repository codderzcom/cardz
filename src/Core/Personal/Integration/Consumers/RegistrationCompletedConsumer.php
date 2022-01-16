<?php

namespace Cardz\Core\Personal\Integration\Consumers;

use Cardz\Core\Personal\Application\Commands\JoinPerson;
use Cardz\Generic\Identity\Integration\Events\RegistrationCompleted;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use Codderz\Platypus\Infrastructure\Messaging\IntegrationEventPayloadProviderTrait;

final class RegistrationCompletedConsumer implements IntegrationEventConsumerInterface
{
    use IntegrationEventPayloadProviderTrait;

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
        $payload = $this->getPayloadOrNull($event);
        if ($payload === null) {
            return;
        }
        $this->commandBus->dispatch(JoinPerson::of($payload->userId, $payload->name));
    }

}
