<?php

namespace App\Shared\Contracts\Messaging;

interface EventBusInterface
{
    public function subscribe(EventConsumerInterface ...$eventConsumers): void;

    public function publish(EventInterface ...$events): void;

    public function hasRecordedEvent($eventIdentifier): bool;
}
