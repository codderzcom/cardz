<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Core\Plans\Integration\Events\PlanAdded;
use Cardz\Core\Plans\Integration\Events\PlanArchived;
use Cardz\Core\Plans\Integration\Events\PlanLaunched;
use Cardz\Core\Plans\Integration\Events\PlanRequirementsChanged;
use Cardz\Core\Plans\Integration\Events\PlanStopped;
use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Cardz\Core\Workspaces\Integration\Events\WorkspaceChanged;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Integration\Mappers\WorkspaceEventToResourceMapper;

final class PlanResourceEventConsumer extends BaseResourceEventConsumer
{
    use RelationAttributeAugmentTrait;

    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        WorkspaceEventToResourceMapper $mapper,
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->mapper = $mapper;
    }

    public function consumes(): array
    {
        return [
            PlanAdded::class,
            PlanArchived::class,
            PlanLaunched::class,
            PlanRequirementsChanged::class,
            PlanStopped::class,
        ];
    }

    protected function augmentAttributes(Resource $resource): void
    {
        $relations = $this->getRelations($resource->workspaceId);
        $resource->appendAttributes([
            'memberIds' => $this->getMemberIds($relations),
            'keeperId' => $this->getKeeperId($relations),
        ]);
        dd($resource);
    }

}
