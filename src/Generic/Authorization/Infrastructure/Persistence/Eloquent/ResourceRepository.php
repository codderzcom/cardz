<?php

namespace Cardz\Generic\Authorization\Infrastructure\Persistence\Eloquent;

use App\Models\Resource as EloquentResource;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function find(RelationId $resourceId, ResourceType $resourceType): Resource
    {
        /** @var EloquentResource $eloquentResource */
        $eloquentResource = EloquentResource::query()
            ->where('resource_id', '=', (string) $resourceId)
            ->where('resource_type', '=', (string) $resourceType)
            ->first();
        if ($eloquentResource === null) {
            throw new RouteNotFoundException("Resource: id $resourceId type $resourceType");
        }
        return $this->resourceFromData($eloquentResource);
    }

    public function persist(Resource $resource): void
    {
        EloquentResource::query()->updateOrCreate(
            ['resource_id' => (string) $resource->resourceId, 'resource_type' => (string) $resource->resourceType],
            $this->resourceAsData($resource)
        );
    }

    private function resourceFromData(EloquentResource $eloquentResource): Resource
    {
        $attributes = is_string($eloquentResource->attributes) ? json_try_decode($eloquentResource->attributes) : $eloquentResource->attributes;
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
