<?php

namespace App\Contexts\Collaboration\Application\Contracts;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Member;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface MemberRepositoryInterface
{
    public function take(CollaboratorId $memberId, WorkspaceId $workspaceId): ?Member;
}
