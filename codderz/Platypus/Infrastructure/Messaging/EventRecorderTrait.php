<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

trait EventRecorderTrait
{
    protected array $recordedEvents = [];

    protected function recordEvent($eventIdentifier, $event)
    {
        $name = is_object($eventIdentifier) ? $eventIdentifier::class : $eventIdentifier;
        $this->recordedEvents[$name] = $event;
    }

    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function hasRecordedEvent($eventIdentifier): bool
    {
        $name = is_object($eventIdentifier) ? $eventIdentifier::class : $eventIdentifier;
        return array_key_exists($name, $this->recordedEvents);
    }
}
