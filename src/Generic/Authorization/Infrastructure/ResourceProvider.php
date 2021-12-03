<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
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
        if (!$resource->isCollaborative()) {
            return;
        }
        $relations = $this->resourceRepository->getByAttributes(
            ResourceType::RELATION(),
            [Attribute::WORKSPACE_ID => $resource(Attribute::WORKSPACE_ID)],
        );
        $memberIds = [];
        /** @var Resource $relation */
        foreach ($relations as $relation) {
            $memberIds[] = $relation(Attribute::COLLABORATOR_ID);
        }
        $resource->appendAttributes([Attribute::MEMBER_IDS => $memberIds]);
    }

}
