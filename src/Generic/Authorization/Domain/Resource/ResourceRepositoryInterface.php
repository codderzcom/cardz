<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

interface ResourceRepositoryInterface
{
    public function find(string $resourceId, ResourceType $resourceType): Resource;

    public function persist(Resource $resource): void;

    public function remove(string $resourceId, ResourceType $resourceType): void;
}
