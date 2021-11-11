<?php

namespace App\Contexts\Cards\Application\Commands;

use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Domain\Model\Card\CardId;

final class NoteAchievement implements CardCommandInterface
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
