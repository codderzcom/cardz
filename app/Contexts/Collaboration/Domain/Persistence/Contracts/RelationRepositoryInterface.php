<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;

interface RelationRepositoryInterface
{
    public function persist(Relation $relation): void;

    /**
     * @throws RelationNotFoundExceptionInterface
     */
    public function take(RelationId $relationId): Relation;
}
