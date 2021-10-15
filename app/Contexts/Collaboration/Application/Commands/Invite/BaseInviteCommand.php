<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;

class BaseInviteCommand implements InviteCommandInterface
{
    protected function __construct(
        protected string $inviteId,
    ) {
    }

    public static function of(string $inviteId): static
    {
        return new static($inviteId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }
}
