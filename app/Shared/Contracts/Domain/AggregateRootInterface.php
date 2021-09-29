<?php

namespace App\Shared\Contracts\Domain;

interface AggregateRootInterface
{
    /**
     * @return DomainEventInterface[]
     */
    public function getEvents(): array;
}
