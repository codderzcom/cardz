<?php

namespace App\Contexts\MobileAppBack\Application\Services\Card;

use App\Contexts\MobileAppBack\Domain\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Card\CardId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class CardService
{
    public function __construct(
        private ServiceResultFactoryInterface $resultFactory,
        private CardsAdapter $cardsAdapter,
    ) {
    }

    public function getCard(CardId $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()->find((string) $cardId);
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        return $this->resultFactory->ok($card);
    }

    public function getCardCode(CardId $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()->find((string) $cardId);
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        $code = CardCode::ofCardId($cardId);
        return $this->resultFactory->ok($code);
    }
}

