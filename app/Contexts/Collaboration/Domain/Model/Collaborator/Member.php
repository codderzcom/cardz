<?php

namespace App\Contexts\Collaboration\Domain\Model\Collaborator;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class Member
{
    private function __construct(
        public CollaboratorId $memberId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function restore(string $memberId, string $workspaceId): self
    {
        return new self(CollaboratorId::of($memberId), WorkspaceId::of($workspaceId));
    }

    public function acceptInvite(): Relation
    {
        return Relation::enter(RelationId::make(), $this->memberId, $this->workspaceId, RelationType::MEMBER());
    }
}
