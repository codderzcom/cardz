<?php

namespace Cardz\Generic\Authorization\Tests\Support\Builders;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class ResourceBuilder extends BaseBuilder
{
    public string $resourceId;

    public string $resourceType;

    public array $attributes;

    public function build(): Resource
    {
        return Resource::restore(
            $this->resourceId,
            $this->resourceType,
            $this->attributes,
        );
    }

    public function withResourceId(string $resourceId): self
    {
        $this->resourceId = $resourceId;
        return $this;
    }

    public function withResourceType(string $resourceType): self
    {
        $this->resourceType = $resourceType;
        return $this;
    }

    public function withAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function generate(): static
    {
        $this->resourceId = GuidBasedImmutableId::makeValue();
        $this->resourceType = ResourceType::NULL;
        $this->attributes = [];
        return $this;
    }
}
