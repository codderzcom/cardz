<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface ProposeInviteCommandInterface extends InviteCommandInterface
{
    public function getKeeperId(): KeeperId;

    public function getMemberId(): CollaboratorId;

    public function getWorkspaceId(): WorkspaceId;
}
