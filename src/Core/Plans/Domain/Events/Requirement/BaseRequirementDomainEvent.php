<?php

namespace Cardz\Core\Plans\Domain\Events\Requirement;

use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseRequirementDomainEvent extends DomainEvent
{
    public function with(): Requirement
    {
        return $this->aggregateRoot;
    }
}
