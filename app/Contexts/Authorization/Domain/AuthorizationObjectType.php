<?php

namespace App\Contexts\Authorization\Domain;

use MyCLabs\Enum\Enum;

final class AuthorizationObjectType extends Enum
{
    public const WORKSPACE = 'workspaces';
    public const PLAN = 'plans';
    public const CARD = 'cards';
}
