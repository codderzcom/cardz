<?php

namespace Cardz\Generic\Authorization\Tests\Support\Mocks;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;

class ResourceInMemoryRepository implements ResourceRepositoryInterface
{
    protected static array $storage = [];

    public function find(string $resourceId, ResourceType $resourceType): Resource
    {
        return static::$storage[(string) $resourceType][$resourceId];
    }

    public function persist(Resource $resource): void
    {
        static::$storage[(string) $resource->resourceType] ??= [];
        static::$storage[(string) $resource->resourceType][(string) $resource->resourceId] = $resource;
    }

    public function remove(string $resourceId, ResourceType $resourceType): void
    {
        unset(static::$storage[(string) $resourceType][$resourceId]);
    }

    public function getByAttributes(ResourceType $resourceType, array $attributes): array
    {
        $results = [];
        /** @var Resource $resource */
        foreach (static::$storage[(string) $resourceType] as $resource) {
            $fits = -count($attributes);
            foreach ($attributes as $name => $value) {
                if ($resource->attr($name)->equals($value)) {
                    $fits++;
                }
            }
            if ($fits === 0) {
                $results[] = $resource;
            }
        }
        return $results;
    }

}
