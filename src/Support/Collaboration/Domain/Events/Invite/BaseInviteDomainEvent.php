<?php

namespace Cardz\Support\Collaboration\Domain\Events\Invite;

use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseInviteDomainEvent extends DomainEvent
{
    public function with(): Invite
    {
        return $this->aggregateRoot;
    }
}
