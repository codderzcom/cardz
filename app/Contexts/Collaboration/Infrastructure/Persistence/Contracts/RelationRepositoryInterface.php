<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;

interface RelationRepositoryInterface
{
    public function persist(Relation $relation): void;

    public function take(RelationId $relationId): ?Relation;
}
