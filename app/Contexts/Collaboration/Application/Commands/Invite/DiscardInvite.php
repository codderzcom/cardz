<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;

final class DiscardInvite implements InviteCommandInterface
{
    protected function __construct(
        protected string $inviteId,
    ) {
    }

    public static function of(string $inviteId): self
    {
        return new self($inviteId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }
}
