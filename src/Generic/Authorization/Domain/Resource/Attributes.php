<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes as AbacAttributes;

final class Attributes extends AbacAttributes
{
    public static function fromData(array $data): self
    {
        $attributes = [];
        foreach ($data as $item) {
            $attributes[] = Attribute::fromArray($item);
        }
        return self::of($attributes);
    }
}
