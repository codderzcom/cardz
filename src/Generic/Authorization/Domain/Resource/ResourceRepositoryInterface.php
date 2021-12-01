<?php

namespace Cardz\Generic\Authorization\Domain\Resource;

use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;

interface ResourceRepositoryInterface
{
    public function find(RelationId $resourceId, ResourceType $resourceType): Resource;

    public function persist(Resource $resource): void;
}
