<?php

namespace App\Contexts\Collaboration\Domain\Model\Invite;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteRejected;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Invite implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $proposed = null;

    private ?Carbon $accepted = null;

    private function __construct(
        public InviteId $inviteId,
        public CollaboratorId $memberId,
        public WorkspaceId $workspaceId,
    ) {
    }

    public static function propose(InviteId $inviteId, CollaboratorId $memberId, WorkspaceId $workspaceId): self
    {
        $invite = new self($inviteId, $memberId, $workspaceId);
        $invite->proposed = Carbon::now();
        return $invite->withEvents(InviteProposed::of($invite));
    }

    public static function restore(string $inviteId, string $memberId, string $workspaceId, ?Carbon $proposed, ?Carbon $accepted): self
    {
        $invite = new self(InviteId::of($inviteId), CollaboratorId::of($memberId), WorkspaceId::of($workspaceId));
        $invite->proposed = $proposed;
        $invite->accepted = $accepted;
        return $invite;
    }

    public function accept(): self
    {
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
