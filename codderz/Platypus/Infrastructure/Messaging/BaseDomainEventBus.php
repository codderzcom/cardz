<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Codderz\Platypus\Contracts\Messaging\BaseDomainEventBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;

abstract class BaseDomainEventBus implements BaseDomainEventBusInterface
{
    public function __construct(
        private EventBusInterface $eventBus,
    ) {
    }

    public function subscribe(EventConsumerInterface $consumer): void
    {
        $this->eventBus->subscribe($consumer);
    }

    public function publish(EventInterface ...$domainEvents): void
    {
        $this->eventBus->publish(...$domainEvents);
    }

    public function hasEvent($eventIdentifier): bool
    {
        return $this->eventBus->hasRecordedEvent($eventIdentifier);
    }
}
