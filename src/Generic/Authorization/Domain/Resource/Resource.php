<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Attribute\Attributes;

final class Resource
{
    private function __construct(
        public ResourceId $resourceId,
        public ResourceType $resourceType,
        public Attributes $attributes,
    ) {
    }

    public static function restore(string $resourceId, string $resourceType, array $attributes): self
    {
        return new self(ResourceId::of($resourceId), ResourceType::of($resourceType), Attributes::fromData($attributes));
    }

    public function appendAttributes(array $newAttributes, bool $replace = true): void
    {
        $oldAttributes = $this->attributes->toArray();
        $attributes = $replace ? array_merge($oldAttributes, $newAttributes) : array_merge($newAttributes, $oldAttributes);
        $this->attributes = Attributes::fromData($attributes);
    }

    public function __get(string $name)
    {
        return $this->attributes->filter(fn(Attribute $item) => $item->getName() === $name)->first()?->getValue();
    }
}
