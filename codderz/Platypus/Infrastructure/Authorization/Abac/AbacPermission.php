<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\PermissionInterface;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;
use MyCLabs\Enum\Enum;

class AbacPermission extends Enum implements PermissionInterface
{
    /**
     * @throws AuthorizationFailedException
     */
    public static function of(string $permission): static
    {
        return static::isValid($permission)
            ? new static($permission)
            : throw new AuthorizationFailedException("Unknown permission");
    }
}
