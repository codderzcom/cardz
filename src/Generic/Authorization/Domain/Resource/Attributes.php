<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes as AbacAttributes;

final class Attributes extends AbacAttributes
{
    public static function of(array $attributes): static
    {
        $collection = new static();
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $collection[$attribute->getName()] = $attribute;
        }
        return $collection;
    }

    public static function fromData(array $attributeItems): self
    {
        $attributes = [];
        foreach ($attributeItems as $name => $value) {
            $attributes[] = Attribute::of($name, $value);
        }
        return self::of($attributes);
    }

    public function toArray()
    {
        $attributes = [];
        /** @var Attribute $attribute */
        foreach ($this as $attribute) {
            $attributes[$attribute->getName()] = $attribute->getValue();
        }
        return $attributes;
    }
}
