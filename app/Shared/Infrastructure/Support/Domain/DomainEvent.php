<?php

namespace App\Shared\Infrastructure\Support\Domain;

use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Contracts\Domain\DomainEventInterface;
use App\Shared\Infrastructure\Support\ShortClassNameTrait;
use Carbon\Carbon;

abstract class DomainEvent implements DomainEventInterface
{
    use ShortClassNameTrait;

    private Carbon $on;

    protected function __construct(
        protected AggregateRootInterface $aggregateRoot
    ) {
        $this->on = Carbon::now();
    }

    public static function occurredIn(AggregateRootInterface $aggregateRoot): static
    {
        return new static($aggregateRoot);
    }

    public function on(): Carbon
    {
        return $this->on;
    }

    abstract public function with(): AggregateRootInterface;

    public function __toString(): string
    {
        return $this::shortName();
    }
}
