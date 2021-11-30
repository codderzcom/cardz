<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\Achievement;
use Cardz\Core\Cards\Domain\Model\Card\CardId;

final class FixAchievementDescription implements CardCommandInterface
{
    private function __construct(
        private string $cardId,
        private string $achievementId,
        private string $achievementDescription,
    ) {
    }

    public static function of(string $cardId, string $achievementId, string $achievementDescription): self
    {
        return new self($cardId, $achievementId, $achievementDescription);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

    public function getAchievement(): Achievement
    {
        return Achievement::of($this->achievementId, $this->achievementDescription);
    }

}
