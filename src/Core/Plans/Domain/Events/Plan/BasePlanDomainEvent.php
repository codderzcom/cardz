<?php

namespace Cardz\Core\Plans\Domain\Events\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BasePlanDomainEvent extends DomainEvent
{
    public function with(): Plan
    {
        return $this->aggregateRoot;
    }
}
