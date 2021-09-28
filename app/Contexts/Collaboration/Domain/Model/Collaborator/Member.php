<?php

namespace App\Contexts\Collaboration\Domain\Model\Collaborator;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class Member
{
    public function __construct(
        public CollaboratorId $memberId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public function acceptInvite(): Relation
    {
        return Relation::make(RelationId::make(), $this->memberId, $this->workspaceId);
    }
}
