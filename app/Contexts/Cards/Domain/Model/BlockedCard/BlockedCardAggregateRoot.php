<?php

namespace App\Contexts\Cards\Domain\Model\BlockedCard;

use App\Contexts\Cards\Domain\Events\BlockedCard\BlockedCardUnblocked;
use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Model\AggregateRoot;
use App\Contexts\Cards\Domain\Model\Card\Achievement;
use Carbon\Carbon;

class BlockedCardAggregateRoot extends AggregateRoot
{
    private ?Carbon $issued = null;

    private ?string $description = null;

    /** @var array<Achievement> */
    private array $achievements = [];

    private ?Carbon $completed = null;

    private ?Carbon $revoked = null;

    private ?Carbon $blocked = null;

    public function __construct(
        public BlockedCardId $blockedCardId
    ) {
    }

    public function unblock(): BlockedCardUnblocked
    {
        $this->blocked = null;
        return BlockedCardUnblocked::with($this->blockedCardId);
    }

    public function noteAchievement(Achievement $achievement): AchievementNoted
    {
        $this->achievements[(string) $achievement->achievementId] = $achievement;
    }

    public function dismissAchievement(Achievement $achievement): AchievementDismissed
    {
        $this->achievements[(string) $achievement->achievementId] = $achievement;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<Achievement>
     */
    public function getAchievements(): array
    {
        return $this->achievements;
    }

    public function isIssued(): bool
    {
        return $this->issued === null;
    }

    public function isCompleted(): bool
    {
        return $this->completed === null;
    }

    public function isRevoked(): bool
    {
        return $this->revoked === null;
    }

    public function isBlocked(): bool
    {
        return $this->blocked === null;
    }
}
