<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Domain\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class WorkspaceService
{
    public function __construct(
        private ServiceResultFactoryInterface $resultFactory,
        private CardsAdapter $cardsAdapter,
    ) {
    }

    public function getCardByCode(string $code): ServiceResultInterface
    {
        try {
            $cardCode = CardCode::ofCodeString($code);
            $card = EloquentCard::query()->find((string) $cardCode->getCardId());
        } catch (ReconstructionException $exception) {
            return $this->resultFactory->violation($exception->getMessage());
        }

        return $this->resultFactory->ok($card);
    }

    public function addWorkspace(string $customerId)
    {
        return;
    }

    public function changeProfile(string $customerId)
    {
        return;
    }

    public function issueCard(string $planId, string $customerId, string $description): ServiceResultInterface
    {
        $cardId = $this->cardsAdapter->issueCard($planId, $customerId, $description);
        $card = EloquentCard::query()->find($cardId);
        return $this->resultFactory->ok($card);
    }
}
