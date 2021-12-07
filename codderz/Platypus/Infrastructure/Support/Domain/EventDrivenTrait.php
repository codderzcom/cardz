<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

trait EventDrivenTrait
{
    protected string $methodPrefix = 'apply';

    public function apply(AggregateEventInterface ...$aggregateEvents): static
    {
        foreach ($aggregateEvents as $aggregateEvent) {
            $this->applyEvent($aggregateEvent);
        }
        return $this;
    }

    protected function applyEvent(AggregateEventInterface $aggregateEvent): void
    {
        $method = $this->getApplyingMethodName($aggregateEvent);
        if ($method) {
            $this->$method($aggregateEvent);
            return;
        }

        $properties = $aggregateEvent->changeset();
        foreach ($properties as $propertyName => $propertyValue) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $propertyValue;
            }
        }
    }

    protected function getApplyingMethodName(AggregateEventInterface $aggregateEvent): ?string
    {
        $eventName = $aggregateEvent::shortName();
        $methodName = $this->methodPrefix . $eventName;
        return method_exists($this, $methodName) ? $methodName : null;
    }
}
