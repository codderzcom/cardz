<?php

namespace App\Contexts\Collaboration\Domain\Model\Invite;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use App\Contexts\Collaboration\Domain\Exceptions\InvalidOperationException;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Invite implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $proposed = null;

    private ?Carbon $acceptedAt = null;

    private ?Carbon $discardedAt = null;

    private ?CollaboratorId $collaboratorId = null;

    private function __construct(
        public InviteId $inviteId,
        public InviterId $inviterId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function propose(InviteId $inviteId, InviterId $inviterId, WorkspaceId $workspaceId): self
    {
        $invite = new self($inviteId, $inviterId, $workspaceId);
        $invite->proposed = Carbon::now();
        return $invite->withEvents(InviteProposed::of($invite));
    }

    public static function restore(
        string $inviteId,
        string $inviterId,
        string $workspaceId,
        ?Carbon $proposed,
    ): self {
        $invite = new self(InviteId::of($inviteId), InviterId::of($inviterId), WorkspaceId::of($workspaceId));
        $invite->proposed = $proposed;
        return $invite;
    }

    public function accept(CollaboratorId $collaboratorId): self
    {
        if ($this->inviterId->equals($collaboratorId)) {
            throw new CannotAcceptOwnInviteException();
        }
        $this->acceptedAt = Carbon::now();
        $this->collaboratorId = $collaboratorId;
        return $this->withEvents(InviteAccepted::of($this));
    }

    public function discard(): self
    {
        $this->discardedAt = Carbon::now();
        return $this->withEvents(InviteDiscarded::of($this));
    }

    public function isAccepted(): bool
    {
        return $this->acceptedAt !== null;
    }

    public function isDiscarded(): bool
    {
        return $this->discardedAt !== null;
    }

    public function getCollaboratorId(): CollaboratorId
    {
        if ($this->collaboratorId === null) {
            throw new InvalidOperationException();
        }

        return $this->collaboratorId;
    }
}
