<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AcceptInvite implements AcceptInviteCommandInterface
{
    private function __construct(
        private string $inviteId,
        private string $memberId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $inviteId, string $memberId, string $workspaceId): self
    {
        return new self($inviteId, $memberId, $workspaceId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }

    public function getMemberId(): CollaboratorId
    {
        return CollaboratorId::of($this->memberId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

}
