<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface ProposeInviteCommandInterface extends InviteCommandInterface
{
    public function getInviteId(): InviteId;

    public function getKeeperId(): KeeperId;

    public function getWorkspaceId(): WorkspaceId;
}
