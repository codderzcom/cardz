<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Core\Cards\Integration\Events\AchievementDismissed;
use Cardz\Core\Cards\Integration\Events\AchievementNoted;
use Cardz\Core\Cards\Integration\Events\CardBlocked;
use Cardz\Core\Cards\Integration\Events\CardCompleted;
use Cardz\Core\Cards\Integration\Events\CardIssued;
use Cardz\Core\Cards\Integration\Events\CardRevoked;
use Cardz\Core\Cards\Integration\Events\CardSatisfactionWithdrawn;
use Cardz\Core\Cards\Integration\Events\CardSatisfied;
use Cardz\Core\Cards\Integration\Events\CardUnblocked;
use Cardz\Core\Cards\Integration\Events\RequirementsAccepted;
use Cardz\Generic\Authorization\Domain\Exceptions\ResourceNotFoundExceptionInterface;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Integration\Mappers\CardEventToResourceMapper;

final class CardResourceEventConsumer extends BaseResourceEventConsumer
{
    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        CardEventToResourceMapper $mapper,
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->mapper = $mapper;
    }

    public function consumes(): array
    {
        return [
            AchievementNoted::class,
            AchievementDismissed::class,
            CardBlocked::class,
            CardCompleted::class,
            CardIssued::class,
            CardRevoked::class,
            CardSatisfactionWithdrawn::class,
            CardSatisfied::class,
            CardUnblocked::class,
            RequirementsAccepted::class,
        ];
    }

    protected function getAdditionalAttributes(Resource $resource): array
    {
        $workspaceId = null;
        try {
            $plan = $this->resourceRepository->find($resource->planId, ResourceType::PLAN());
            $workspaceId = $plan->workspaceId;
        } catch (ResourceNotFoundExceptionInterface) {
        }
        return ['workspaceId' => $workspaceId];
    }

}
