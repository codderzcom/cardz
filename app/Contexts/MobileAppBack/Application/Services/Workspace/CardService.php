<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertCardInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Plan\PlanId;
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

    public function getCardByCode(string $code): ServiceResultInterface
    {
        try {
            $cardCode = CardCode::ofCodeString($code);
            $cardId = (string) $cardCode->getCardId();
            $card = $this->issuedCardReadStorage->find($cardId);
            if ($card === null) {
                return $this->serviceResultFactory->notFound("Card not found for $cardId");
            }
        } catch (ReconstructionException $exception) {
            return $this->serviceResultFactory->violation($exception->getMessage());
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function issue(string $workspaceId, string $planId, string $customerId, string $description): ServiceResultInterface
    {
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->issueCard($planId, $customerId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $cardId = $result->getPayload();

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId could not be found after creation");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function complete(string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->completeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function revoke(string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->revokeCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function block(string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->blockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function unblock(string $workspaceId, string $cardId): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->unblockCard($cardId);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function noteAchievement(string $workspaceId, string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->noteAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

    public function dismissAchievement(string $workspaceId, string $cardId,  string $achievementId, string $description): ServiceResultInterface
    {
        if (!AssertCardInWorkspace::of(CardId::of($cardId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Illegal workspace");
        }

        $result = $this->cardsAdapter->dismissAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->violation("Card $cardId not found");
        }

        return $this->serviceResultFactory->ok($card);
    }

}
