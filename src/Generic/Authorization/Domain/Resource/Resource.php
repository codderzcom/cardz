<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;

final class Resource
{
    private function __construct(
        public RelationId $resourceId,
        public ResourceType $resourceType,
        public Attributes $attributes,
    ) {
    }

    public static function restore(string $resourceId, string $resourceType, array $attributes): self
    {
        return new self(RelationId::of($resourceId), ResourceType::of($resourceType), Attributes::fromData($attributes));
    }

    public function appendAttributes(array $attributes): void
    {
        $this->attributes->merge(...Attributes::fromData($attributes));
    }

    public function __get(string $name)
    {
        $this->attributes->filter(fn(Attribute $item) => $item->getName() === $name)->first()?->getValue();
    }
}
