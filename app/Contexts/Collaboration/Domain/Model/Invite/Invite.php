<?php

namespace App\Contexts\Collaboration\Domain\Model\Invite;

use App\Contexts\Auth\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteRejected;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Carbon\Carbon;

final class Invite extends AggregateRoot
{
    private ?Carbon $proposed = null;

    private function __construct(
        public InviteId $inviteId,
        public CollaboratorId $collaboratorId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function make(InviteId $inviteId, CollaboratorId $collaboratorId, WorkspaceId $workspaceId): self
    {
        return new self($inviteId, $collaboratorId, $workspaceId);
    }

    public function propose(): InviteProposed
    {
        $this->proposed = Carbon::now();
        return InviteProposed::with($this->inviteId);
    }

    public function accept(): InviteAccepted
    {
        return InviteAccepted::with($this->inviteId);
    }

    public function discard(): InviteDiscarded
    {
        return InviteDiscarded::with($this->inviteId);
    }

    public function reject(): InviteRejected
    {
        return InviteRejected::with($this->inviteId);
    }

    public function isProposed(): bool
    {
        return $this->proposed !== null;
    }

    private function from(
        string $inviteId,
        string $collaboratorId,
        string $workspaceId,
        ?Carbon $proposed,
    ): self {
        $this->inviteId = InviteId::of($inviteId);
        $this->collaboratorId = CollaboratorId::of($collaboratorId);
        $this->workspaceId = WorkspaceId::of($workspaceId);
        $this->proposed = $proposed;
        return $this;
    }
}
