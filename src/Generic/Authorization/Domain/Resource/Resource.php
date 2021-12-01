<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

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

    public function appendAttributes(array $attributes, bool $replace = true): void
    {
        if ($replace) {
            dump($this->attributes, Attributes::fromData($attributes));
            $this->attributes = $this->attributes->merge(...Attributes::fromData($attributes)->all());
            dump($this->attributes);
        } else {
            $newAttributes = Attributes::fromData($attributes);
            $this->attributes = $newAttributes->merge(...$this->attributes);
        }
    }

    public function __get(string $name)
    {
        $this->attributes->filter(fn(Attribute $item) => $item->getName() === $name)->first()?->getValue();
    }
}
