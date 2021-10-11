<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Cards;

use App\Contexts\Cards\Application\Services\CardAppService;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class CardsAdapter
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private CardAppService $cardAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function issueCard(string $planId, string $customerId, string $description): ServiceResultInterface
    {
        $result = $this->cardAppService->issue($planId, $customerId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $cardId = (string) $result->getPayload()->cardId;
        return $this->serviceResultFactory->ok($cardId);
    }

    public function completeCard(string $cardId): ServiceResultInterface
    {
        $result = $this->cardAppService->complete($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function revokeCard(string $cardId): ServiceResultInterface
    {
        $result = $this->cardAppService->revoke($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function blockCard(string $cardId): ServiceResultInterface
    {
        $result = $this->cardAppService->block($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function unblockCard(string $cardId): ServiceResultInterface
    {
        $result = $this->cardAppService->unblock($cardId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function noteAchievement(string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        $result = $this->cardAppService->noteAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function dismissAchievement(string $cardId, string $achievementId, string $description): ServiceResultInterface
    {
        $result = $this->cardAppService->dismissAchievement($cardId, $achievementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

}
