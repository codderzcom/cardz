<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;

final class AcceptInvite implements InviteCommandInterface
{
    private function __construct(
        private string $inviteId,
        private string $collaboratorId,
    ) {
    }

    public static function of(string $inviteId, string $collaboratorId): self
    {
        return new self($inviteId, $collaboratorId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }

    public function getCollaboratorId(): CollaboratorId
    {
        return CollaboratorId::of($this->collaboratorId);
    }

}
