<?php

namespace Cardz\Generic\Authorization\Domain\Attribute;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;

final class Attributes implements AttributeCollectionInterface
{
    /** @var Attribute[]  */
    private array $attributes = [];

    public function __construct(
        Attribute ...$attributes
    ) {
        foreach ($attributes as $attribute) {
            $this->attributes[$attribute->getName()] = $attribute;
        }
    }

    public static function of(Attribute ...$attributes): self
    {
        return new self(...$attributes);
    }

    public static function fromData(array $attributeItems): self
    {
        $collection = new self();
        foreach ($attributeItems as $name => $value) {
            $collection->attributes[$name] = Attribute::of($name, $value);
        }
        return $collection;
    }

    public function toArray()
    {
        $attributes = [];
        /** @var Attribute $attribute */
        foreach ($this->attributes as $attribute) {
            $attributes[$attribute->getName()] = $attribute->getValue();
        }
        return $attributes;
    }

    public function get(string $attributeName)
    {
        $attribute = $this->attributes[$attributeName] ?? null;
        if ($attribute === null) {
            throw new AuthorizationFailedException("Attribute $attributeName not found");
        }
        return $attribute->getValue();
    }

    public function getValue(string $attributeName)
    {
        $attribute = $this->attributes[$attributeName] ?? null;
        return $attribute?->getValue();
    }

    public function count()
    {
        return count($this->attributes);
    }
}
