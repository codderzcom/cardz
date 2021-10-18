<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Member;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\MemberRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\MemberNotFoundException;
use App\Models\Invite as EloquentMember;

class MemberRepository implements MemberRepositoryInterface
{
    public function take(CollaboratorId $memberId, WorkspaceId $workspaceId): Member
    {
        // ToDo: а надо вообще из репа брать?
        $member = EloquentMember::query()
            ->where('member_id', '=', (string) $memberId)
            ->where('workspace_id', '=', (string) $workspaceId)
            ->first();
        return $member ? Member::restore($member->id, $member->workspace_id) : throw new MemberNotFoundException((string) $memberId);
    }
}
