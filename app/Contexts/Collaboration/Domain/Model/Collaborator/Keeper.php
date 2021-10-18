<?php

namespace App\Contexts\Collaboration\Domain\Model\Collaborator;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class Keeper
{
    private function __construct(
        public CollaboratorId $keeperId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function restore(string $keeperId, string $workspaceId): self
    {
        return new self(CollaboratorId::of($keeperId), WorkspaceId::of($workspaceId));
    }

    public function invite(CollaboratorId $memberId): Invite
    {
        return Invite::propose(InviteId::make(), $memberId, $this->workspaceId);
    }

    public function keepWorkspace(): Relation
    {
        return Relation::enter(RelationId::make(), $this->keeperId, $this->workspaceId, RelationType::KEEPER());
    }
}
