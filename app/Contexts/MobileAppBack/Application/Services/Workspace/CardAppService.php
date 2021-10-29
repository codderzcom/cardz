<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Queries\Workspace\GetCard;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertCardInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\PlanId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class CardAppService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardsAdapter $cardsAdapter,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getCard(GetCard $query): IssuedCard
    {
        return $this->issuedCardReadStorage->forKeeper($query->keeperId, $query->workspaceId, $query->cardId);
    }

    private function getIssuedCardResult(string $cardId): ServiceResultInterface
    {
        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Cards $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function issue(string $keeperId, string $workspaceId, string $planId, string $customerId, string $description): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->issueCard($planId, $customerId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $cardId = $result->getPayload();
        return $this->getIssuedCardResult($cardId);
    }

    public function complete(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->completeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->getIssuedCardResult($cardId);
    }

    public function revoke(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->revokeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->getIssuedCardResult($cardId);
    }

    public function block(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->blockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->getIssuedCardResult($cardId);
    }

    public function unblock(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->unblockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function noteAchievement(string $keeperId, string $workspaceId, string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();

        $result = $this->cardsAdapter->noteAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->getIssuedCardResult($cardId);
    }

    public function dismissAchievement(string $keeperId, string $workspaceId, string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert();
        $result = $this->cardsAdapter->dismissAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->getIssuedCardResult($cardId);
    }

}
