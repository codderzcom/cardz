<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardRevoked extends BaseCardDomainEvent
{
    public static function with(CardId $cardId): static
    {
        return new static($cardId);
    }
}
