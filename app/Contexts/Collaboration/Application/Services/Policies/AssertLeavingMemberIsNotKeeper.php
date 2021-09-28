<?php

namespace App\Contexts\Collaboration\Application\Services\Policies;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Shared\Contracts\PolicyAssertionInterface;
use App\Contexts\Shared\Contracts\PolicyViolationInterface;
use App\Contexts\Shared\Infrastructure\Policy\PolicyViolation;
use App\Models\Relation as EloquentRelation;
use JetBrains\PhpStorm\Pure;

final class AssertLeavingMemberIsNotKeeper implements PolicyAssertionInterface
{
    private function __construct(
        private RelationId $relationId,
    ) {
    }

    #[Pure]
    public static function of(RelationId $relationId): self
    {
        return new self($relationId);
    }

    public function assert(): bool
    {
        $relation = EloquentRelation::query()->find((string) $this->relationId);
        if ($relation === null) {
            return true;
        }

        return !RelationType::of($relation->relation_type)->equals(RelationType::KEEPER());

    }

    public function violation(): PolicyViolationInterface
    {
        return PolicyViolation::of("Cannot leave KEEPER relation");
    }

}
