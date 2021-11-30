<?php

namespace Codderz\Platypus\Contracts\Domain;

use Codderz\Platypus\Contracts\Messaging\EventInterface;
use JsonSerializable;

interface AggregateRootInterface extends JsonSerializable
{
    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array;

    /**
     * @return EventInterface[]
     */
    public function tapEvents(): array;
}
