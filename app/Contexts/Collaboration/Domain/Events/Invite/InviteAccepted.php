<?php

namespace App\Contexts\Collaboration\Domain\Events\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class InviteAccepted extends BaseInviteDomainEvent
{
    public static function with(InviteId $inviteId): self
    {
        return new self($inviteId);
    }
}
