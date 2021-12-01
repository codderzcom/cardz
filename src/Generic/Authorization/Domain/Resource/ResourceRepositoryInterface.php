<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

interface ResourceRepositoryInterface
{
    public function find(string $resourceId, ResourceType $resourceType): Resource;

    public function persist(Resource $resource): void;
}
