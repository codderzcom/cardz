<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\ReadModel\AcceptedInvite;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AcceptedInviteReadStorageInterface;
use App\Models\Invite as EloquentInvite;

class AcceptedInviteReadStorage implements AcceptedInviteReadStorageInterface
{
    public function take(string $inviteId): ?AcceptedInvite
    {
        $eloquentInvite = EloquentInvite::query()
            ->where('id', '=', $inviteId)
            ->whereNotNull('accepted_at')
            ->first();
        if ($eloquentInvite === null) {
            return null;
        }
        return new AcceptedInvite(
            InviteId::of($eloquentInvite->id),
            CollaboratorId::of($eloquentInvite->member_id),
            WorkspaceId::of($eloquentInvite->workspace_id)
        );
    }

    public function find(string $memberId, string $workspaceId): ?AcceptedInvite
    {
        $eloquentInvite = EloquentInvite::query()
            ->where('member_id', '=', $memberId)
            ->where('workspace_id', '=', $workspaceId)
            ->whereNotNull('accepted_at')
            ->first();
        if ($eloquentInvite === null) {
            return null;
        }
        return new AcceptedInvite(
            InviteId::of($eloquentInvite->id),
            CollaboratorId::of($eloquentInvite->member_id),
            WorkspaceId::of($eloquentInvite->workspace_id)
        );
    }

}
