<?php

namespace App\Contexts\Auth\Domain\User\Events;

use App\Contexts\Auth\Domain\Events\BaseDomainEvent;
use App\Contexts\Auth\Domain\Model\User\UserId;

abstract class BaseUserDomainEvent extends BaseDomainEvent
{
    protected function __construct(public UserId $userId)
    {
        parent::__construct();
    }
}
