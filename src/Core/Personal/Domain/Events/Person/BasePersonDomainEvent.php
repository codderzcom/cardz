<?php

namespace Cardz\Core\Personal\Domain\Events\Person;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BasePersonDomainEvent extends DomainEvent
{
    public function with(): Person
    {
        return $this->aggregateRoot;
    }
}
