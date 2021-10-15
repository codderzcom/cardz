<?php

namespace App\Contexts\Collaboration\Application\Commands\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;

class BaseRelationCommand implements RelationCommandInterface
{
    private function __construct(
        protected string $relationId,
    ) {
    }

    public static function of(string $relationId): static
    {
        return new static($relationId);
    }

    public function getRelationId(): RelationId
    {
        return RelationId::of($this->relationId);
    }
}
