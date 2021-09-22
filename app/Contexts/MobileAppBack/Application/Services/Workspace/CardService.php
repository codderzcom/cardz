<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertCardForKeeper;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertCardInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\PlanId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class CardService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardsAdapter $cardsAdapter,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getCardByCode(string $keeperId, string $code): ServiceResultInterface
    {
        try {
            $cardCode = CardCode::ofCodeString($code);
            $cardId = (string) $cardCode->getCardId();
        } catch (ReconstructionException $exception) {
            return $this->serviceResultFactory->violation($exception->getMessage());
        }

        if (!AssertCardForKeeper::of(CardId::of($cardId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Card $cardId is not for keeper $keeperId");
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function issue(string $keeperId, string $workspaceId, string $planId, string $customerId, string $description): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->cardsAdapter->issueCard($planId, $customerId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $cardId = $result->getPayload();

        return $this->getIssuedCardResult($cardId);
    }

    public function complete(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->completeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function revoke(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->revokeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function block(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->blockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function unblock(string $keeperId, string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->unblockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function noteAchievement(string $keeperId, string $workspaceId, string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->noteAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    public function dismissAchievement(string $keeperId, string $workspaceId, string $cardId,  string $achievementId, string $description): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->dismissAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getIssuedCardResult($cardId);
    }

    private function getIssuedCardResult(string $cardId): ServiceResultInterface
    {
        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

}
