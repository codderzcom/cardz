<?php

namespace App\Contexts\Workspaces\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;

interface DomainEventBusInterface
{
    public function subscribe(EventConsumerInterface $consumer): void;

    public function publish(EventInterface ...$domainEvents): void;

    public function hasEvent($eventIdentifier): bool;
}
