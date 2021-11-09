<?php

namespace App\Contexts\Authorization\Dictionary;

use App\Contexts\Authorization\Exceptions\AuthorizationFailedException;
use App\Shared\Infrastructure\Authorization\Abac\AbacPermission;

/**
 * @method static AbacPermission WORKSPACES_VIEW()
 * @method static AbacPermission WORKSPACES_CHANGE_PROFILE()
 * @method static AbacPermission WORKSPACES_PLANS_ADD()
 * @method static AbacPermission PLANS_VIEW()
 * @method static AbacPermission PLANS_CHANGE()
 */
class PermissionRepository
{
    protected static array $permissions = [
        'WORKSPACES_VIEW' => 'workspaces.view',
        'WORKSPACES_CHANGE_PROFILE' => 'workspaces.change_profile',
        'WORKSPACES_PLANS_ADD' => 'workspaces.plans.add',
        'PLANS_VIEW' => 'plans.view',
        'PLANS_CHANGE' => 'plans.change',
    ];

    public static function __callStatic(string $name, array $arguments): AbacPermission
    {
        return array_key_exists($name, static::$permissions)
            ? AbacPermission::of(static::$permissions[$name])
            : throw new AuthorizationFailedException('Unknown Permission');
    }
}
