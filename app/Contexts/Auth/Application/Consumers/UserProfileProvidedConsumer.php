<?php

namespace App\Contexts\Auth\Application\Consumers;

use App\Contexts\Auth\Domain\Events\User\ProfileProvided;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Integration\Events\RegistrationCompleted;
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
