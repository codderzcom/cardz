<?php

namespace App\Contexts\Collaboration\Domain\ReadModel;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AcceptedInvite
{
    public function __construct(
        public InviteId $inviteId,
        public CollaboratorId $memberId,
        public WorkspaceId $workspaceId,
    ) {
    }
}
