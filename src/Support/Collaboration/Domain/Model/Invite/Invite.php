<?php

namespace Cardz\Support\Collaboration\Domain\Model\Invite;

use Carbon\Carbon;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteAccepted;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteDiscarded;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteProposed;
use Cardz\Support\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use Cardz\Support\Collaboration\Domain\Exceptions\InvalidOperationException;
use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

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
