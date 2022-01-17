<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Workspace;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessCard;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessCardNotFoundException;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts\BusinessCardReadStorageInterface;
use Cardz\Support\MobileAppGateway\Integration\Contracts\CardsContextInterface;

class CardAppService
{
    public function __construct(
        private CardsContextInterface $cardsContext,
        private BusinessCardReadStorageInterface $businessCardReadStorage,
    ) {
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function getCard(string $cardId): BusinessCard
    {
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function issue(string $planId, string $customerId): BusinessCard
    {
        $cardId = $this->cardsContext->issue($planId, $customerId);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function complete(string $cardId): BusinessCard
    {
        $this->cardsContext->complete($cardId);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function revoke(string $cardId): BusinessCard
    {
        $this->cardsContext->revoke($cardId);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function block(string $cardId): BusinessCard
    {
        $this->cardsContext->block($cardId);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function unblock(string $cardId): BusinessCard
    {
        $this->cardsContext->unblock($cardId);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function noteAchievement(string $cardId, string $achievementId, string $description): BusinessCard
    {
        $this->cardsContext->noteAchievement($cardId, $achievementId, $description);
        return $this->businessCardReadStorage->find($cardId);
    }

    /**
     * @throws BusinessCardNotFoundException
     */
    public function dismissAchievement(string $cardId, string $achievementId): BusinessCard
    {
        $this->cardsContext->dismissAchievement($cardId, $achievementId);
        return $this->businessCardReadStorage->find($cardId);
    }

}
