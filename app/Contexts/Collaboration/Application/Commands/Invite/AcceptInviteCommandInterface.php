<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface AcceptInviteCommandInterface extends InviteCommandInterface
{
    public function getCollaboratorId(): CollaboratorId;

    public function getWorkspaceId(): WorkspaceId;
}
