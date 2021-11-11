<?php

namespace App\Contexts\Collaboration\Domain\Model\Workspace;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviterId;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;

final class Keeper
{
    private function __construct(
        public KeeperId $keeperId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function restore(string $keeperId, string $workspaceId): self
    {
        return new self(KeeperId::of($keeperId), WorkspaceId::of($workspaceId));
    }

    public function invite(InviteId $inviteId): Invite
    {
        return Invite::propose($inviteId, InviterId::of((string) $this->keeperId), $this->workspaceId);
    }

    public function keep(RelationId $relationId): Relation
    {
        return Relation::establish($relationId, $this->getCollaboratorId(), $this->workspaceId, RelationType::KEEPER());
    }

    private function getCollaboratorId(): CollaboratorId
    {
        return CollaboratorId::of((string) $this->keeperId);
    }
}
