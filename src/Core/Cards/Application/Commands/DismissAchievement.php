<?php

namespace Cardz\Core\Cards\Application\Commands;

use Cardz\Core\Cards\Domain\Model\Card\CardId;
use JetBrains\PhpStorm\Pure;

final class DismissAchievement implements CardCommandInterface
{
    private function __construct(
        private string $cardId,
        private string $achievementId,
    ) {
    }

    #[Pure]
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
