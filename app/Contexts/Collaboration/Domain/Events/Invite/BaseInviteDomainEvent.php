<?php

namespace App\Contexts\Collaboration\Domain\Events\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseInviteDomainEvent extends DomainEvent
{
    public function with(): Invite
    {
        return $this->aggregateRoot;
    }
}
