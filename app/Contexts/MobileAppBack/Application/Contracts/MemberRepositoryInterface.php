<?php

namespace App\Contexts\MobileAppBack\Application\Contracts;

use App\Contexts\MobileAppBack\Domain\Model\Collaboration\Keeper;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;

interface MemberRepositoryInterface
{
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): ?Keeper;
}
