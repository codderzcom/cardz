<?php

namespace Cardz\Support\Collaboration\Application\Commands\Invite;

use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;

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
