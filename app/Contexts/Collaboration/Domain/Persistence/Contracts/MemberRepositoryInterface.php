<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\MemberNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Member;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface MemberRepositoryInterface
{
    /**
     * @throws MemberNotFoundExceptionInterface
     */
    public function take(CollaboratorId $memberId, WorkspaceId $workspaceId): Member;
}
