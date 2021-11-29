<?php

namespace App\Contexts\Identity\Application\Consumers;

use App\Contexts\Identity\Domain\Events\User\ProfileProvided;
use App\Contexts\Identity\Domain\Model\User\User;
use App\Contexts\Identity\Integration\Events\RegistrationCompleted;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;

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
