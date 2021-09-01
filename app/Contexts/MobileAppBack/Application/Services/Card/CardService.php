<?php

namespace App\Contexts\MobileAppBack\Application\Services\Card;

use App\Contexts\MobileAppBack\Domain\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Exceptions\ReconstructionException;
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

    public function getCard(string $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()->find($cardId);
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        return $this->resultFactory->ok($card);
    }

    public function getCardCode(string $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()->find($cardId);
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        $code = CardCode::ofCardId(CardId::of($cardId));
        return $this->resultFactory->ok($code);
    }
}

