<?php

namespace Cardz\Generic\Identity\Application\Consumers;

use Cardz\Generic\Identity\Domain\Events\User\ProfileProvided;
use Cardz\Generic\Identity\Domain\Model\User\User;
use Cardz\Generic\Identity\Integration\Events\RegistrationCompleted;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

class UserProfileProvidedConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            ProfileProvided::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->with();
        $this->integrationEventBus->publish(RegistrationCompleted::of($user));
    }

}
