<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;

final class DismissAchievement implements CardCommandInterface
{
    private function __construct(
        private string $cardId,
        private string $achievementId,
    ) {
    }

    public static function of(string $cardId, string $achievementId): self
    {
        return new self($cardId, $achievementId);
    }

    public function getCardId(): CardId
    {
        return CardId::of($this->cardId);
    }

    public function getAchievementId(): string
    {
        return $this->achievementId;
    }

}
