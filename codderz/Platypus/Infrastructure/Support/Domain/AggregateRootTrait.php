<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;

trait AggregateRootTrait
{
    use ArrayPresenterTrait;

    /**
     * @var EventInterface[]
     */
    protected array $events = [];

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @return EventInterface[]
     */
    public function tapEvents(): array
    {
        return $this->events;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    protected function withEvents(EventInterface ...$domainEvents): static
    {
        $this->events = array_merge($this->events, $domainEvents);
        return $this;
    }
}
