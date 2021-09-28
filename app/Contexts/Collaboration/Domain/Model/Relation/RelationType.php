<?php

namespace App\Contexts\Collaboration\Domain\Model\Relation;

use MyCLabs\Enum\Enum;

/**
 * @method static RelationType KEEPER()
 * @method static RelationType MEMBER()
 * @method static RelationType PENDING()
 * @method static RelationType NOBODY()
 */
final class RelationType extends Enum
{
    public const KEEPER = 'keeper';
    public const MEMBER = 'member';
    public const PENDING = 'pending';
    public const NOBODY = 'nobody';

    public static function of(string $relationType): self
    {
        return self::isValid($relationType) ? new self($relationType) : self::NOBODY();
    }
}
