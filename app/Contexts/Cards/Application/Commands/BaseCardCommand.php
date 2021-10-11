<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;

class BaseCardCommand implements CardCommandInterface
{
    private function __construct(
        protected string $cardId,
    ) {
    }

    public static function of(string $cardId): static
    {
        return new static(CardId::of($cardId));
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

}
