<?php

namespace Cardz\Support\Collaboration\Domain\Model\Relation;

use Carbon\Carbon;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationEstablished;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationLeft;
use Cardz\Support\Collaboration\Domain\Exceptions\InvalidOperationException;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

final class Relation implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $established = null;

    private ?Carbon $left = null;

    private function __construct(
        public RelationId $relationId,
        public CollaboratorId $collaboratorId,
        public WorkspaceId $workspaceId,
        public RelationType $relationType,
    ) {
    }

    public static function establish(RelationId $relationId, CollaboratorId $collaboratorId, WorkspaceId $workspaceId, RelationType $relationType): self
    {
        $relation = new self($relationId, $collaboratorId, $workspaceId, $relationType);
        $relation->established = Carbon::now();
        return $relation->withEvents(RelationEstablished::of($relation));
    }

    public static function restore(
        string $relationId,
        string $collaboratorId,
        string $workspaceId,
        string $relationType,
        ?Carbon $established,
        ?Carbon $left,
    ): self {
        $relation = new self(RelationId::of($relationId), CollaboratorId::of($collaboratorId), WorkspaceId::of($workspaceId), RelationType::of($relationType));
        $relation->established = $established;
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

    public function isLeft(): bool
    {
        return $this->left !== null;
    }
}
