<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\CardId;

class BaseCardCommand implements CardCommandInterface
{
    protected function __construct(
        protected string $cardId,
    ) {
    }

    public static function of(string $cardId): static
    {
        return new static($cardId);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

}
