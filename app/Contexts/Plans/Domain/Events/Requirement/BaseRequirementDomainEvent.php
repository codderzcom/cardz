<?php

namespace App\Contexts\Plans\Domain\Events\Requirement;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseRequirementDomainEvent extends DomainEvent
{
    public function with(): Requirement
    {
        return $this->aggregateRoot;
    }
}
