<?php

namespace App\Contexts\Collaboration\Domain\Events\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseRelationDomainEvent extends DomainEvent
{
    public function with(): Relation
    {
        return $this->aggregateRoot;
    }
}
