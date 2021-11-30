<?php

namespace Cardz\Support\Collaboration\Application\Commands\Relation;

use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationType;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

final class EstablishRelation implements CommandInterface
{
    private function __construct(
        private string $relationId,
        private string $collaboratorId,
        private string $workspaceId,
        private string $relationType,
    ) {
    }

    public static function of(string $collaboratorId, string $workspaceId, string $relationType): self
    {
        return new self(RelationId::makeValue(), $collaboratorId, $workspaceId, $relationType);
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

    public function getRelationType(): RelationType
    {
        return RelationType::of($this->relationType);
    }
}
