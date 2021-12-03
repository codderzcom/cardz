<?php

namespace Cardz\Core\Personal\Application\Consumers;

use Cardz\Core\Personal\Domain\Events\Person\PersonJoined as DomainPersonJoined;
use Cardz\Core\Personal\Domain\Events\Person\PersonNameChanged as DomainPersonNameChanged;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Integration\Events\PersonJoined;
use Cardz\Core\Personal\Integration\Events\PersonNameChanged;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

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
