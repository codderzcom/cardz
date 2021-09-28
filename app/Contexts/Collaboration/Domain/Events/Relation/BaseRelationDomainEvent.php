<?php

namespace App\Contexts\Collaboration\Domain\Events\Relation;

use App\Contexts\Collaboration\Domain\Events\BaseDomainEvent;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;

abstract class BaseRelationDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public RelationId $relationId
    ) {
        parent::__construct();
    }
}
