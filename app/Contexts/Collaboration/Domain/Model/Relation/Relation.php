<?php

namespace App\Contexts\Collaboration\Domain\Model\Relation;

use App\Contexts\Collaboration\Domain\Events\Relation\RelationEntered;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationLeft;
use App\Contexts\Collaboration\Domain\Exceptions\InvalidOperationException;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Relation implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $entered = null;

    private ?Carbon $left = null;

    private function __construct(
        public RelationId $relationId,
        public CollaboratorId $collaboratorId,
        public WorkspaceId $workspaceId,
        public RelationType $relationType,
    ) {
    }

    public static function register(RelationId $relationId, CollaboratorId $collaboratorId, WorkspaceId $workspaceId, RelationType $relationType): self
    {
        $relation = new self($relationId, $collaboratorId, $workspaceId, $relationType);
        $relation->entered = Carbon::now();
        return $relation->withEvents(RelationEntered::of($relation));
    }

    public static function restore(
        string $relationId,
        string $collaboratorId,
        string $workspaceId,
        string $relationType,
        ?Carbon $entered,
        ?Carbon $left,
    ): self {
        $relation = new self(RelationId::of($relationId), CollaboratorId::of($collaboratorId), WorkspaceId::of($workspaceId), RelationType::of($relationType));
        $relation->entered = $entered;
        $relation->left = $left;
        return $relation;
    }

    public function leave(): self
    {
        if ($this->relationType->equals(RelationType::KEEPER())) {
            throw new InvalidOperationException("Keeper is not allowed to leave");
        }
        $this->left = Carbon::now();
        return $this->withEvents(RelationLeft::of($this));
    }
}
