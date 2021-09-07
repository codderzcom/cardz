<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class WorkspaceService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardsAdapter $cardsAdapter,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
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
        return $this->serviceResultFactory->ok($card);
    }
}
