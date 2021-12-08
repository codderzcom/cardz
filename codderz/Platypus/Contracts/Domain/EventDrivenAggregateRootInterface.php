<?php

namespace Codderz\Platypus\Contracts\Domain;

use Codderz\Platypus\Contracts\GenericIdInterface;
use JsonSerializable;

interface EventDrivenAggregateRootInterface extends JsonSerializable
{
    /**
     * @return AggregateEventInterface[]
     */
    public function releaseEvents(): array;

    /**
     * @return AggregateEventInterface[]
     */
    public function tapEvents(): array;

    public function id(): GenericIdInterface;

    public function recordThat(AggregateEventInterface ...$aggregateEvents): static;

    public function apply(AggregateEventInterface ...$aggregateEvents): static;

}
