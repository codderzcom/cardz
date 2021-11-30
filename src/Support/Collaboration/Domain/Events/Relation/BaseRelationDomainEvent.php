<?php

namespace Cardz\Support\Collaboration\Domain\Events\Relation;

use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseRelationDomainEvent extends DomainEvent
{
    public function with(): Relation
    {
        return $this->aggregateRoot;
    }
}
