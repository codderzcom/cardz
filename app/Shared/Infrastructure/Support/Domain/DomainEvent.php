<?php

namespace App\Shared\Infrastructure\Support\Domain;

use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Contracts\Domain\DomainEventInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Infrastructure\Support\ShortClassNameTrait;
use Carbon\Carbon;

abstract class DomainEvent implements EventInterface, DomainEventInterface
{
    use ShortClassNameTrait;

    private Carbon $at;

    protected function __construct(
        protected AggregateRootInterface $aggregateRoot
    ) {
        $this->at = Carbon::now();
    }

    public static function of(AggregateRootInterface $aggregateRoot): static
    {
        return new static($aggregateRoot);
    }

    public function at(): Carbon
    {
        return $this->at;
    }

    abstract public function with(): AggregateRootInterface;

    public function __toString(): string
    {
        return $this::shortName();
    }

    public function jsonSerialize()
    {
        return [
            'domainEvent' => $this::shortName(),
            'at' => $this->at,
            'with' => $this->aggregateRoot->jsonSerialize(),
        ];
    }
}
