<?php

namespace App\Contexts\MobileAppBack\Application\Services\Card;

use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultFactoryInterface;
use App\Contexts\MobileAppBack\Application\Services\Shared\ApplicationServiceResult;
use App\Contexts\MobileAppBack\Domain\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Card\CardId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Models\Card as EloquentCard;

class CardService
{
    public function __construct(
        private ApplicationServiceResultFactoryInterface $resultFactory,
        private CardsAdapter $cardsAdapter,
    ) {
    }

    public function getCard(CardId $cardId): ApplicationServiceResult
    {
        $card = EloquentCard::query()->find((string) $cardId);
        if ($card === null) {
            return $this->resultFactory->notFound();
        }
        return $this->resultFactory->ok($card);
    }

    public function getCardCode(CardId $cardId): ApplicationServiceResult
    {
        $card = EloquentCard::query()->find((string) $cardId);
        if ($card === null) {
            return $this->resultFactory->notFound();
        }
        $code = CardCode::ofCardId($cardId);
        return $this->resultFactory->ok($card);
    }
}

