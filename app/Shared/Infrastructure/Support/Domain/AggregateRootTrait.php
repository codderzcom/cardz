<?php

namespace App\Shared\Infrastructure\Support\Domain;

use App\Shared\Contracts\Domain\DomainEventInterface;

trait AggregateRootTrait
{
    /**
     * @var DomainEventInterface[]
     */
    protected array $events = [];


    protected function withEvents(DomainEventInterface ...$domainEvents): static
    {
        $this->events[] = array_merge($this->events, $domainEvents);
        return $this;
    }

    /**
     * @return DomainEventInterface[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
