<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class CardBlocked extends BaseCardDomainEvent
{
    public static function with(CardId $cardId): self
    {
        return new self($cardId);
    }
}
