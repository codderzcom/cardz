<?php

namespace App\Contexts\Collaboration\Domain\Events\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RelationLeft extends BaseRelationDomainEvent
{
    public static function with(RelationId $relationId): self
    {
        return new self($relationId);
    }
}
