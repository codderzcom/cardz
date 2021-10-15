<?php

namespace App\Contexts\Collaboration\Domain\Model\Relation;

use App\Contexts\Collaboration\Domain\Events\Relation\RelationEntered;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationLeft;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Carbon\Carbon;

final class Relation extends AggregateRoot
{
    private RelationType $relationType;

    private ?Carbon $entered = null;

    private ?Carbon $left = null;

    private function __construct(
        public RelationId $relationId,
        public CollaboratorId $collaboratorId,
        public WorkspaceId $workspaceId,
    ) {
        $this->relationType = RelationType::PENDING();
    }

    public static function make(RelationId $relationId, CollaboratorId $collaboratorId, WorkspaceId $workspaceId): self
    {
        return new self($relationId, $collaboratorId, $workspaceId);
    }

    public function enter(RelationType $relationType): RelationEntered
    {
        $this->relationType = $relationType;
        $this->entered = Carbon::now();
        return RelationEntered::with($this->relationId);
    }

    public function leave(): RelationLeft
    {
        $this->left = Carbon::now();
        return RelationLeft::with($this->relationId);
    }

    public function getRelationType(): RelationType
    {
        return $this->relationType;
    }

    public function isEntered(): bool
    {
        return $this->entered !== null && $this->left === null;
    }

    public function isLeft(): bool
    {
        return $this->left !== null && $this->entered !== null;
    }

    private function from(
        string $relationId,
        string $collaboratorId,
        string $workspaceId,
        string $relationType,
        ?Carbon $entered,
        ?Carbon $left,
    ): self
    {
        $this->relationId = RelationId::of($relationId);
        $this->collaboratorId = CollaboratorId::of($collaboratorId);
        $this->workspaceId = WorkspaceId::of($workspaceId);
        $this->relationType = RelationType::of($relationType);
        $this->entered = $entered;
        $this->left = $left;
        return $this;
    }
}
