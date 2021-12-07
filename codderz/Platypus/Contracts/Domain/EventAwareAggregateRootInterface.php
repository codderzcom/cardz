<?php

namespace Codderz\Platypus\Contracts\Domain;

use Codderz\Platypus\Contracts\GenericIdInterface;
use JsonSerializable;

interface EventAwareAggregateRootInterface extends JsonSerializable
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
}
