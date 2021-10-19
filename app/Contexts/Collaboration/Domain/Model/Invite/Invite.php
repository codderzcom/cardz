<?php

namespace App\Contexts\Collaboration\Domain\Model\Invite;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteRejected;
use App\Contexts\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Invite implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $proposed = null;

    private ?CollaboratorId $collaboratorId = null;

    private ?Carbon $accepted = null;

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
        ?string $collaboratorId,
        ?Carbon $proposed,
        ?Carbon $accepted
    ): self {
        $invite = new self(InviteId::of($inviteId), InviterId::of($inviterId), WorkspaceId::of($workspaceId));
        $invite->collaboratorId = $collaboratorId !== null ? CollaboratorId::of($collaboratorId) : null;
        $invite->proposed = $proposed;
        $invite->accepted = $accepted;
        return $invite;
    }

    public function accept(CollaboratorId $collaboratorId): self
    {
        if ($this->inviterId->equals($collaboratorId)) {
            throw new CannotAcceptOwnInviteException();
        }
        $this->collaboratorId = $collaboratorId;
        $this->accepted = Carbon::now();
        return $this->withEvents(InviteAccepted::of($this));
    }

    public function discard(): self
    {
        return $this->withEvents(InviteDiscarded::of($this));
    }

    public function reject(): self
    {
        return $this->withEvents(InviteRejected::of($this));
    }
}
