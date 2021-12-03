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
use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Exceptions\ResourceNotFoundException;
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
        $keeperId = null;
        try {
            $plan = $this->resourceRepository->find($resource(Attribute::PLAN_ID), ResourceType::PLAN());
            $workspaceId = $plan(Attribute::WORKSPACE_ID);
            $keeperId = $plan(Attribute::KEEPER_ID);
        } catch (ResourceNotFoundException) {
        }
        return [
            Attribute::WORKSPACE_ID => $workspaceId,
            Attribute::KEEPER_ID => $keeperId,
        ];
    }

}
