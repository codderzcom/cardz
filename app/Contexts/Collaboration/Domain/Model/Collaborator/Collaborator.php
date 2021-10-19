<?php

namespace App\Contexts\Collaboration\Domain\Model\Collaborator;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class Collaborator
{
    private function __construct(
        public CollaboratorId $collaboratorId,
    ) {
    }

    public static function restore(string $collaboratorId): self
    {
        return new self(CollaboratorId::of($collaboratorId));
    }

    public function collaborate(WorkspaceId $workspaceId): Relation
    {
        return Relation::register(RelationId::make(), $this->collaboratorId, $workspaceId, RelationType::MEMBER());
    }
}
