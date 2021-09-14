<?php

namespace App\Contexts\Auth\Domain\Events\User;

use App\Contexts\Auth\Domain\Model\User\UserId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class ProfileProvided extends BaseUserDomainEvent
{
    public static function with(UserId $userId): self
    {
        return new self($userId);
    }
}
