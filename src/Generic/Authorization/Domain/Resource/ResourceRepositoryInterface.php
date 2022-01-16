<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Cardz\Generic\Authorization\Exceptions\ResourceNotFoundException;

interface ResourceRepositoryInterface
{
    /**
     * @throws ResourceNotFoundException
     */
    public function find(string $resourceId, ResourceType $resourceType): Resource;

    public function persist(Resource $resource): void;

    public function remove(string $resourceId, ResourceType $resourceType): void;

    /** Resource[] */
    public function getByAttributes(ResourceType $resourceType, array $attributes): array;
}
