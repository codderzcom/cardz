<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardCode;
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
        return $this->serviceResultFactory->ok('');
    }

    public function complete(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

    public function revoke(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

    public function block(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

    public function unblock(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

    public function noteAchievement(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

    public function dismissAchievement(string $workspaceId, string $cardId): ServiceResultInterface
    {
        return $this->serviceResultFactory->ok('');
    }

}
