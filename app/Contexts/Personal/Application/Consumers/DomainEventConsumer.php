<?php

namespace App\Contexts\Personal\Application\Consumers;

use App\Contexts\Personal\Domain\Events\Person\PersonJoined as DomainPersonJoined;
use App\Contexts\Personal\Domain\Events\Person\PersonNameChanged as DomainPersonNameChanged;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Integration\Events\PersonJoined;
use App\Contexts\Personal\Integration\Events\PersonNameChanged;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;

final class DomainEventConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            DomainPersonJoined::class,
            DomainPersonNameChanged::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Person $person */
        $person = $event->with();
        $integrationEvent = match ($event::class) {
            DomainPersonJoined::class => PersonJoined::of($person),
            DomainPersonNameChanged::class => PersonNameChanged::of($person),
            default => null,
        };

        if ($integrationEvent === null) {
            return;
        }

        $this->integrationEventBus->publish($integrationEvent);
    }

}
