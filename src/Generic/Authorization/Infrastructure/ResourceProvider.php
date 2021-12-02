<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Domain\Attribute\Attributes;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Contracts\GeneralIdInterface;

class ResourceProvider implements ResourceProviderInterface
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
    ) {
    }

    public function getResourceAttributes(
        ?GeneralIdInterface $resourceId,
        ResourceType $resourceType
    ): Attributes {
        if ($resourceId === null) {
            return Attributes::fromData([]);
        }
        $resource = $this->resourceRepository->find($resourceId, $resourceType);
        $this->augmentResource($resource);
        return $resource->attributes;
    }

    private function augmentResource(Resource $resource): void
    {
        if (!$resource->workspaceId || $resource->resourceType->equals(ResourceType::RELATION())) {
            return;
        }
        $relations = $this->resourceRepository->getByAttributes(ResourceType::RELATION(), ['workspaceId' => $resource->workspaceId]);
        $memberIds = [];
        /** @var Resource $relation */
        foreach ($relations as $relation) {
            $memberIds[] = $relation->collaboratorId;
        }
        $resource->appendAttributes(['memberIds' => $memberIds]);
    }

}
