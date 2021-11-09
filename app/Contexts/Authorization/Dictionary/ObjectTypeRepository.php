<?php

namespace App\Contexts\Authorization\Dictionary;

use App\Contexts\Authorization\Domain\AuthorizationObjectType;
use App\Contexts\Authorization\Exceptions\AuthorizationFailedException;

/**
 * @method static AuthorizationObjectType WORKSPACE()
 * @method static AuthorizationObjectType PLAN()
 * @method static AuthorizationObjectType CARD()
 */
class ObjectTypeRepository
{
    public static function __callStatic(string $name, array $arguments): AuthorizationObjectType
    {
        return AuthorizationObjectType::isValidKey($name)
            ? AuthorizationObjectType::$name()
            : throw new AuthorizationFailedException('Unknown Object Type');
    }
}
