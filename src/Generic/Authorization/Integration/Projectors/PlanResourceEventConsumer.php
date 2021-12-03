<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Core\Plans\Integration\Events\PlanAdded;
use Cardz\Core\Plans\Integration\Events\PlanArchived;
use Cardz\Core\Plans\Integration\Events\PlanLaunched;
use Cardz\Core\Plans\Integration\Events\PlanRequirementsChanged;
use Cardz\Core\Plans\Integration\Events\PlanStopped;
use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Exceptions\ResourceNotFoundException;
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

    protected function getAdditionalAttributes(Resource $resource): array
    {
        $keeperId = null;
        try {
            $workspace = $this->resourceRepository->find($resource(Attribute::WORKSPACE_ID), ResourceType::WORKSPACE());
            $keeperId = $workspace(Attribute::KEEPER_ID);
        } catch (ResourceNotFoundException) {
        }
        return [Attribute::KEEPER_ID => $keeperId];
    }

}
