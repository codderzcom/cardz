<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\Domain\EventAwareAggregateRootInterface;
use Codderz\Platypus\Contracts\GenericIdInterface;
use ReflectionClass;
use ReflectionProperty;

trait AggregateEventTrait
{
    protected Carbon $at;

    protected EventAwareAggregateRootInterface $aggregateRoot;

    protected GenericIdInterface $aggregateRootId;

    private array $exclude = [];

    public function changeset(): array
    {
        $changeset = [];
        $class = new ReflectionClass($this);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
        $excluded = $this->getExcludedPropertyNames();
        foreach ($properties as $property) {
            $name = $property->getName();
            $property->setAccessible(true);
            if (!in_array($name, $excluded, true)) {
                $changeset[$property->getName()] = $property->getValue($this);
            }
        }
        return $changeset;
    }

    public function stream(): GenericIdInterface
    {
        return $this->aggregateRootId;
    }

    public function at(): Carbon
    {
        return $this->at;
    }

    public function with(): EventAwareAggregateRootInterface
    {
        return $this->aggregateRoot;
    }

    public function in(EventAwareAggregateRootInterface $aggregateRoot): static
    {
        $this->at ??= Carbon::now();
        $this->aggregateRoot = $aggregateRoot;
        $this->aggregateRootId = $aggregateRoot->id();
        return $this;
    }

    protected function getExcludedPropertyNames(): array
    {
        return $this->exclude;
    }

}
