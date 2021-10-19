<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class ProposeInvite implements ProposeInviteCommandInterface
{
    private function __construct(
        private string $inviteId,
        private string $keeperId,
        private string $memberId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $keeperId, string $memberId, string $workspaceId): self
    {
        return new self(InviteId::makeValue(), $keeperId, $memberId, $workspaceId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
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
