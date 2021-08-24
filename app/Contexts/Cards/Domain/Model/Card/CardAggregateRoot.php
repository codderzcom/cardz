<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Domain\Model\AggregateRoot;
use Carbon\Carbon;

class CardAggregateRoot extends AggregateRoot
{
    private ?Carbon $issued = null;

    private ?string $description = null;

    /** @var array<Achievement> */
    private array $achievements = [];

    private ?Carbon $completed = null;

    private ?Carbon $revoked = null;

    private ?Carbon $blocked = null;

    public function __construct(
        public CardId $cardId
    ) {
    }

    public function issue(): CardIssued
    {
        $this->issued = Carbon::now();
        return CardIssued::with($this->cardId);
    }

    public function complete(): CardCompleted
    {
        $this->completed = Carbon::now();
        return CardCompleted::with($this->cardId);
    }

    public function revoke(): CardRevoked
    {
        $this->revoked = Carbon::now();
        return CardRevoked::with($this->cardId);
    }

    public function block(): CardBlocked
    {
        $this->blocked = Carbon::now();
        return CardBlocked::with($this->cardId);
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
