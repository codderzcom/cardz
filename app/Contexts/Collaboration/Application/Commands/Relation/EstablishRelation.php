<?php

namespace App\Contexts\Collaboration\Application\Commands\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class EstablishRelation implements EstablishRelationCommandInterface
{
    private function __construct(
        private string $relationId,
        private string $collaboratorId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $collaboratorId, string $workspaceId): self
    {
        return new self(RelationId::makeValue(), $collaboratorId, $workspaceId);
    }

    public function getRelationId(): RelationId
    {
        return RelationId::of($this->relationId);
    }

    public function getCollaboratorId(): CollaboratorId
    {
        return CollaboratorId::of($this->collaboratorId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }
}
