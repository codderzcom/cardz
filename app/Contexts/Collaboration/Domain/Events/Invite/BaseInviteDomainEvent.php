<?php

namespace App\Contexts\Collaboration\Domain\Events\Invite;

use App\Contexts\Collaboration\Domain\Events\BaseDomainEvent;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;

abstract class BaseInviteDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public InviteId $inviteId
    ) {
        parent::__construct();
    }
}
