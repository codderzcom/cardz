<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\PermissionInterface;
use App\Shared\Exceptions\AuthorizationFailedException;
use MyCLabs\Enum\Enum;

class AbacPermission extends Enum implements PermissionInterface
{
    public static function of(string $permission): static
    {
        return static::isValid($permission)
            ? new static($permission)
            : throw new AuthorizationFailedException("Unknown permission");
    }
}
