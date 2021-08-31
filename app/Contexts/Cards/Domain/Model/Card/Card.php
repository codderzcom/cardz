<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Domain\Model\AggregateRoot;
use App\Contexts\Cards\Domain\Model\Shared\CustomerId;
use App\Contexts\Cards\Domain\Model\Shared\PlanId;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;

class Card extends AggregateRoot
{
    private ?Carbon $issued = null;

    private ?Carbon $completed = null;

    private ?Carbon $revoked = null;

    private ?Carbon $blocked = null;

    /** @var array<Achievement> */
    private array $achievements = [];

    private function __construct(
        public CardId $cardId,
        public PlanId $planId,
        public CustomerId $customerId,
        public Description $description,
    ) {
    }

    #[Pure]
    public static function make(CardId $cardId, PlanId $planId, CustomerId $customerId, Description $description): static
    {
        return new static($cardId, $planId, $customerId, $description);
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

    public function noteAchievement(string $description): AchievementNoted
    {
        $achievement = $this->createAchievement($description);
        if ($achievement) {
            $this->achievements[(string) $achievement->achievementId] = $achievement;
        }
        return AchievementNoted::with($this->cardId, $achievement->achievementId);
    }

    public function dismissAchievement(AchievementId $achievementId): AchievementDismissed
    {
        unset($this->achievements[(string) $achievementId]);
        return AchievementDismissed::with($this->cardId, $achievementId);
    }

    public function getDescription(): ?Description
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
        return $this->issued !== null;
    }

    public function isCompleted(): bool
    {
        return $this->completed !== null;
    }

    public function isRevoked(): bool
    {
        return $this->revoked !== null;
    }

    public function isBlocked(): bool
    {
        return $this->blocked !== null;
    }

    private function createAchievement(string $description): ?Achievement
    {
        $reflection = new ReflectionClass(Achievement::class);
        $constructor = $reflection->getConstructor();
        $constructor?->setAccessible(true);
        /** @var ?Achievement $achievement */
        $achievement = $reflection->newInstanceWithoutConstructor();
        $constructor?->invoke($achievement, AchievementId::make(), $description);
        return $achievement;
    }

    private function from(
        string $cardId,
        string $planId,
        string $customerId,
        string $description,
        ?Carbon $issued = null,
        ?Carbon $completed = null,
        ?Carbon $revoked = null,
        ?Carbon $blocked = null,
        array $achievements = [],
    ): void {
        $this->cardId = CardId::of($cardId);
        $this->planId = PlanId::of($planId);
        $this->customerId = CustomerId::of($customerId);
        $this->description = Description::of($description);
        $this->issued = $issued;
        $this->completed = $completed;
        $this->revoked = $revoked;
        $this->blocked = $blocked;
        $this->achievements = $achievements;
    }
}
