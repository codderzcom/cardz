<?php

namespace App\Shared\Contracts\Authorization;

use MyCLabs\Enum\Enum;

/**
 * @method static AuthorizationResolution ALLOW()
 * @method static AuthorizationResolution DENY()
 * @method static AuthorizationResolution NOT_APPLICABLE()
 */
class AuthorizationResolution extends Enum
{
    public const ALLOW = 'allow';
    public const DENY = 'deny';
    public const NOT_APPLICABLE = 'n/a';

    public static function of(?bool $allows = null): static
    {
        return match ($allows) {
            true => static::ALLOW(),
            false => static::DENY(),
            default => static::NOT_APPLICABLE(),
        };
    }

    public function acceptRestrictive(AuthorizationResolution $resolution): static
    {
        return $resolution->isRestrictive() ? static::DENY() : $this;
    }

    public function acceptPermissive(AuthorizationResolution $resolution): static
    {
        return $resolution->isPermissive() ? static::ALLOW() : $this;
    }

    public function isPermissive(): bool
    {
        return $this->equals(static::ALLOW());
    }

    public function isRestrictive(): bool
    {
        return $this->equals(static::DENY());
    }
}
