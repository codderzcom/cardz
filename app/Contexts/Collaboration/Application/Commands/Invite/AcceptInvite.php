<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AcceptInvite implements AcceptInviteCommandInterface
{
    private function __construct(
        private string $inviteId,
        private string $collaboratorId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $inviteId, string $collaboratorId, string $workspaceId): self
    {
        return new self($inviteId, $collaboratorId, $workspaceId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }

    public function getCollaboratorId(): CollaboratorId
    {
        return CollaboratorId::of($this->collaboratorId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

}
