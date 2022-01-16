<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\Achievement;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Pure;

final class FixAchievementDescription implements CardCommandInterface
{
    private function __construct(
        private string $cardId,
        private string $achievementId,
        private string $achievementDescription,
    ) {
    }

    #[Pure]
    public static function of(string $cardId, string $achievementId, string $achievementDescription): self
    {
        return new self($cardId, $achievementId, $achievementDescription);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

    #[Pure]
    public function getAchievement(): Achievement
    {
        return Achievement::of($this->achievementId, $this->achievementDescription);
    }

}
