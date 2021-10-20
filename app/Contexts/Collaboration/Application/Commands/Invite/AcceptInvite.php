<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AcceptInvite implements AcceptInviteCommandInterface
{
    private function __construct(
        private string $relationId,
        private string $inviteId,
        private string $collaboratorId,
    ) {
    }

    public static function of(string $inviteId, string $collaboratorId): self
    {
        return new self(RelationId::makeValue(), $inviteId, $collaboratorId);
    }

    public function getRelationId(): RelationId
    {
        return RelationId::of($this->relationId);
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
