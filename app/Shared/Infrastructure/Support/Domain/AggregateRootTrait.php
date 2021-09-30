<?php

namespace App\Shared\Infrastructure\Support\Domain;

use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

trait AggregateRootTrait
{
    use ArrayPresenterTrait;

    /**
     * @var EventInterface[]
     */
    protected array $events = [];


    protected function withEvents(EventInterface ...$domainEvents): static
    {
        $this->events = array_merge($this->events, $domainEvents);
        return $this;
    }

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
