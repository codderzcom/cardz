<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Infrastructure\Support\ShortClassNameTrait;

abstract class AggregateEvent implements EventInterface, AggregateEventInterface
{
    use AggregateEventTrait, ShortClassNameTrait;

    public function __toString(): string
    {
        return $this::shortName();
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }
}
