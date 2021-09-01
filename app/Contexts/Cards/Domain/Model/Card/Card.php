<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Cards\Domain\Model\Shared\CustomerId;
use App\Contexts\Cards\Domain\Model\Shared\PlanId;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;

final class Card extends AggregateRoot
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
    public static function make(CardId $cardId, PlanId $planId, CustomerId $customerId, Description $description): self
    {
        return new self($cardId, $planId, $customerId, $description);
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

    public function noteAchievement(RequirementId $requirementId, string $description): AchievementNoted
    {
        $achievement = Achievement::of($requirementId, $description);
        $this->achievements[(string) $achievement->getRequirementId()] = $achievement;
        return AchievementNoted::with($this->cardId, $achievement->getRequirementId());
    }

    public function dismissAchievement(RequirementId $requirementId): AchievementDismissed
    {
        unset($this->achievements[(string) $requirementId]);
        return AchievementDismissed::with($this->cardId, $requirementId);
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
