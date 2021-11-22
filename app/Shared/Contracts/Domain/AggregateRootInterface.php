<?php

namespace App\Shared\Contracts\Domain;

use App\Shared\Contracts\Messaging\EventInterface;
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
