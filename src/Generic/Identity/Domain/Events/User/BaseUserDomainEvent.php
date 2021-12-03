<?php

namespace Cardz\Generic\Identity\Domain\Events\User;

use Cardz\Generic\Identity\Domain\Model\User\User;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseUserDomainEvent extends DomainEvent
{
    public function with(): User
    {
        return $this->aggregateRoot;
    }
}
