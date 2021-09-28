<?php

namespace App\Contexts\MobileAppBack\Domain\Model\Collaboration;

use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;

final class Member
{
    public function __construct(
        public MemberId $keeperId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public function acceptInvite()
    {

    }

    public function rejectInvite()
    {

    }

    public function leaveWorkspace()
    {

    }
}
