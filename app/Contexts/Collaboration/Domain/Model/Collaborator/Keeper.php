<?php

namespace App\Contexts\Collaboration\Domain\Model\Collaborator;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class Keeper
{
    public function __construct(
        public CollaboratorId $keeperId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public function invite(CollaboratorId $memberId): Invite
    {
        return Invite::make(
            InviteId::make(),
            $memberId,
            $this->workspaceId,
        );
    }

    public function keepWorkspace(): Relation
    {
        return Relation::make(
            RelationId::make(),
            $this->keeperId,
            $this->workspaceId,
        );
    }
}
