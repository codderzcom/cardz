<?php

namespace Codderz\Platypus\Contracts\Messaging;

interface BaseDomainEventBusInterface
{
    public function subscribe(EventConsumerInterface $consumer): void;

    public function publish(EventInterface ...$domainEvents): void;

    public function hasEvent($eventIdentifier): bool;
}
