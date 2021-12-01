<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Core\Plans\Integration\Events\PlanAdded;
use Cardz\Core\Plans\Integration\Events\PlanArchived;
use Cardz\Core\Plans\Integration\Events\PlanLaunched;
use Cardz\Core\Plans\Integration\Events\PlanRequirementsChanged;
use Cardz\Core\Plans\Integration\Events\PlanStopped;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Integration\Mappers\PlanEventToResourceMapper;

final class PlanResourceEventConsumer extends BaseResourceEventConsumer
{
    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        PlanEventToResourceMapper $mapper,
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
        $workspace = $this->resourceRepository->find($resource->workspaceId, ResourceType::WORKSPACE());
        $resource->appendAttributes(['memberIds' => $workspace->memberIds], false);
    }

}
