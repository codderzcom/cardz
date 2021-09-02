<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class AchievementDismissed extends BaseCardDomainEvent
{
    private function __construct(
        public CardId $cardId,
        public RequirementId $requirementId
    ) {
        parent::__construct($cardId);
    }

    public static function with(CardId $cardId, RequirementId $requirementId): self
    {
        return new self($cardId, $requirementId);
    }
}
