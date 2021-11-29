<?php

namespace App\Contexts\Identity\Domain\Events\User;

use App\Contexts\Identity\Domain\Model\User\User;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseUserDomainEvent extends DomainEvent
{
    public function with(): User
    {
        return $this->aggregateRoot;
    }
}
