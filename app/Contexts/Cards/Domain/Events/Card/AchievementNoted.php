<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\AchievementId;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class AchievementNoted extends BaseCardDomainEvent
{
    private function __construct(
        public CardId $cardId,
        public AchievementId $achievementId
    ) {
        parent::__construct($cardId);
    }

    public static function with(CardId $cardId, AchievementId $achievementId): static
    {
        return new static($cardId, $achievementId);
    }
}
