<?php

namespace App\Contexts\Personal\Domain\Events\Person;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BasePersonDomainEvent extends DomainEvent
{
    public function with(): Person
    {
        return $this->aggregateRoot;
    }
}
