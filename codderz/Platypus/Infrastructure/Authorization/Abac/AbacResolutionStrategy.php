<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use MyCLabs\Enum\Enum;

/**
 * @method static static PERMISSIVE()
 * @method static static RESTRICTIVE()
 */
class AbacResolutionStrategy extends Enum
{
    public const PERMISSIVE = 'permissive';
    public const RESTRICTIVE = 'restrictive';

    public function isPermissive(): bool
    {
        return $this->equals(static::PERMISSIVE());
    }

    public static function ofConfig(AttributeCollectionInterface $config): static
    {
        $strategy = $config->getValue('abac.strategy');
        return static::isValid($strategy) ? new static($strategy) : static::RESTRICTIVE();
    }
}
