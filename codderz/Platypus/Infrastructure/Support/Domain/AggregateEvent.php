<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Carbon\Carbon;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;

abstract class AggregateEvent implements EventInterface, AggregateEventInterface
{
    use AggregateEventTrait;

    public function at(): Carbon
    {
        return $this->at;
    }

    public function with(): AggregateRootInterface
    {
        return $this->aggregateRoot;
    }

    public function __toString(): string
    {
        return $this::shortName();
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }
}
