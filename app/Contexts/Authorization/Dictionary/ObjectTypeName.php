<?php

namespace App\Contexts\Authorization\Dictionary;

use MyCLabs\Enum\Enum;

/**
 * @method static ObjectTypeName WORKSPACE()
 * @method static ObjectTypeName PLAN()
 * @method static ObjectTypeName CARD()
 * @method static ObjectTypeName NULL()
 */
final class ObjectTypeName extends Enum
{
    public const WORKSPACE = 'workspace';
    public const PLAN = 'plan';
    public const CARD = 'card';
    public const NULL = 'null';
}
