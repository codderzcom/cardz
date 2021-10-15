<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\MemberId;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;

interface ProposeInviteCommandInterface extends InviteCommandInterface
{
    public function getKeeperId(): KeeperId;

    public function getMemberId(): MemberId;

    public function getWorkspaceId(): WorkspaceId;
}
