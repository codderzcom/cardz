<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence;

use App\Contexts\Collaboration\Application\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Member;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Models\Invite as EloquentMember;

class MemberRepository implements MemberRepositoryInterface
{
    public function take(CollaboratorId $memberId, WorkspaceId $workspaceId): ?Member
    {
        $member = EloquentMember::query()
            ->where('member_id', '=', (string) $memberId)
            ->where('workspace_id', '=', (string) $workspaceId)
            ->first();
        return $member ? new Member($memberId, $workspaceId) : null;
    }
}
