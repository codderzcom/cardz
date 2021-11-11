<?php

namespace App\Contexts\Plans\Domain\Events\Plan;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BasePlanDomainEvent extends DomainEvent
{
    public function with(): Plan
    {
        return $this->aggregateRoot;
    }
}
