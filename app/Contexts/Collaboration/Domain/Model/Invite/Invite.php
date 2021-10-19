<?php

namespace App\Contexts\Collaboration\Domain\Model\Invite;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Invite implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $proposed = null;

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

    public function accept(CollaboratorId $collaboratorId): Relation
    {
        if ($this->inviterId->equals($collaboratorId)) {
            throw new CannotAcceptOwnInviteException();
        }
        return Relation::register(RelationId::make(), $collaboratorId, $this->workspaceId, RelationType::MEMBER());
    }

    public function discard(): self
    {
        return $this->withEvents(InviteDiscarded::of($this));
    }
}
