<?php

namespace Cardz\Generic\Identity\Application\Consumers;

use Cardz\Generic\Identity\Application\Commands\ClearTokens;
use Cardz\Generic\Identity\Domain\Events\Token\TokenAssigned;
use Cardz\Generic\Identity\Domain\Model\Token\Token;
use Cardz\Generic\Identity\Integration\Events\TokenIssued;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class TokenAssignedConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            TokenAssigned::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Token $token */
        $token = $event->with();
        $this->integrationEventBus->publish(TokenIssued::of($token));

        $this->commandBus->dispatch(ClearTokens::of($token->userId));
    }
}
