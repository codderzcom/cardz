<?php

namespace Codderz\Platypus\Infrastructure\Support\Domain;

use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Support\JsonPresenterTrait;

trait EventAwareAggregateRootTrait
{
    use JsonPresenterTrait;

    /**
     * @var AggregateEventInterface[]
     */
    protected array $events = [];

    /**
     * @return AggregateEventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @return AggregateEventInterface[]
     */
    public function tapEvents(): array
    {
        return $this->events;
    }

    public function recordThat(AggregateEventInterface ...$aggregateEvents): static
    {
        $this->events = [...$this->events, ...$aggregateEvents];
        $this->apply(...$aggregateEvents);

        foreach ($aggregateEvents as $aggregateEvent) {
            $aggregateEvent->in($this);
        }

        return $this;
    }

    abstract public function apply(AggregateEventInterface ...$aggregateEvents): static;
}
