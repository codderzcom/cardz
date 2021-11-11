<?php

namespace App\Contexts\Auth\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;

class DomainEventBus implements DomainEventBusInterface
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
}
