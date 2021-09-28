<?php

namespace App\Contexts\MobileAppBack\Domain\Model\Collaboration;

use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;

final class Keeper
{
    public function __construct(
        public KeeperId $keeperId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public function proposeInvite()
    {

    }

    public function discardInvite()
    {

    }
}
