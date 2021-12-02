<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Codderz\Platypus\Exceptions\ParameterAssertionException;
use MyCLabs\Enum\Enum;

/**
 * @method static self SUBJECT()
 *
 * @method static self WORKSPACE()
 * @method static self PLAN()
 * @method static self CARD()
 * @method static self RELATION()
 *
 * @method static self NULL()
 */
final class ResourceType extends Enum
{
    public const SUBJECT = 'subject';

    public const WORKSPACE = 'workspace';
    public const PLAN = 'plan';
    public const CARD = 'card';
    public const RELATION = 'relation';

    public const NULL = 'null';

    public static function of(string $type): self
    {
        return self::isValid($type) ? new self($type) : throw new ParameterAssertionException("Resource type $type unknown");
    }
}
