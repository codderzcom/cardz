<?php

namespace Cardz\Generic\Authorization\Infrastructure\Persistence\Eloquent;

use App\Models\Resource as EloquentResource;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Infrastructure\Exceptions\ResourceNotFoundException;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function find(string $resourceId, ResourceType $resourceType): Resource
    {
        /** @var EloquentResource $eloquentResource */
        $eloquentResource = EloquentResource::query()
            ->where('resource_id', '=', $resourceId)
            ->where('resource_type', '=', (string) $resourceType)
            ->first();
        if ($eloquentResource === null) {
            throw new ResourceNotFoundException("Resource: id $resourceId type $resourceType");
        }
        return $this->resourceFromData($eloquentResource);
    }

    public function persist(Resource $resource): void
    {
        EloquentResource::query()->updateOrCreate(
            ['resource_id' => (string) $resource->resourceId, 'resource_type' => (string) $resource->resourceType],
            $this->resourceAsData($resource),
        );
    }

    public function remove(string $resourceId, ResourceType $resourceType): void
    {
        EloquentResource::query()
            ->where('resource_id', '=', $resourceId)
            ->where('resource_type', '=', (string) $resourceType)
            ->delete();
    }

    private function resourceFromData(EloquentResource $eloquentResource): Resource
    {
        $attributes = is_string($eloquentResource->attributes) ? json_try_decode($eloquentResource->attributes, true) : $eloquentResource->attributes;
        return Resource::restore(
            $eloquentResource->resource_id,
            $eloquentResource->resource_type,
            $attributes,
        );
    }

    private function resourceAsData(Resource $resource): array
    {
        return [
            'resource_id' => (string) $resource->resourceId,
            'resource_type' => (string) $resource->resourceType,
            'attributes' => $resource->attributes->toArray(),
        ];
    }

}
