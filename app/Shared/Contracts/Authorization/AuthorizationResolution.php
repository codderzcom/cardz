<?php

namespace App\Shared\Contracts\Authorization;

use MyCLabs\Enum\Enum;

/**
 * @method static AuthorizationResolution ALLOW()
 * @method static AuthorizationResolution DENY()
 */
class AuthorizationResolution extends Enum
{
    public const ALLOW = 'allow';
    public const DENY = 'deny';

    public static function of(?bool $allows): static
    {
        return $allows === true ? static::ALLOW() : static::DENY();
    }

    public function isPermissive(): bool
    {
        return $this->equals(static::ALLOW());
    }
}
