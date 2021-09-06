<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RequirementsAccepted extends BaseCardDomainEvent
{
    private function __construct(
        public CardId $cardId,
    ) {
        parent::__construct($cardId);
    }

    public static function with(CardId $cardId): self
    {
        return new self($cardId);
    }
}
