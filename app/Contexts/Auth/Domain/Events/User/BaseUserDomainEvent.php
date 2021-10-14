<?php

namespace App\Contexts\Auth\Domain\Events\User;

use App\Contexts\Auth\Domain\Model\User\User;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseUserDomainEvent extends DomainEvent
{
    public function with(): User
    {
        return $this->aggregateRoot;
    }
}
