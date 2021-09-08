<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\BaseCardDomainEvent;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfactionWthdrawn;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfied;
use App\Contexts\Cards\Domain\Events\Card\RequirementsAccepted;
use App\Contexts\Cards\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Cards\Domain\Model\Shared\CustomerId;
use App\Contexts\Cards\Domain\Model\Shared\PlanId;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Card extends AggregateRoot
{
    private ?Carbon $issued = null;

    private ?Carbon $satisfied = null;

    private ?Carbon $completed = null;

    private ?Carbon $revoked = null;

    private ?Carbon $blocked = null;

    private Achievements $achievements;

    private Achievements $requirements;

    private function __construct(
        public CardId $cardId,
        public PlanId $planId,
        public CustomerId $customerId,
        public Description $description,
    ) {
        $this->achievements = Achievements::of();
        $this->requirements = Achievements::of();
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

    public function satisfy(): CardSatisfied
    {
        $this->satisfied = Carbon::now();
        return CardSatisfied::with($this->cardId);
    }

    public function withdrawSatisfaction(): CardSatisfactionWthdrawn
    {
        $this->satisfied = null;
        return CardSatisfactionWthdrawn::with($this->cardId);
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
        $this->achievements = $this->achievements->add($achievement);
        return AchievementNoted::with($this->cardId);
    }

    public function dismissAchievement(Achievement $achievement): AchievementDismissed
    {
        $this->achievements = $this->achievements->remove($achievement);
        return AchievementDismissed::with($this->cardId);
    }

    public function acceptRequirements(Achievements $requirements): RequirementsAccepted
    {
        if (!$this->isSatisfied() && !$this->isCompleted()) {
            $this->requirements = $requirements;
        }
        return RequirementsAccepted::with($this->cardId);
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function getAchievements(): Achievements
    {
        return $this->achievements;
    }

    public function getRequirements(): Achievements
    {
        return $this->requirements;
    }

    public function isIssued(): bool
    {
        return $this->issued !== null;
    }

    public function isSatisfied(): bool
    {
        return $this->satisfied !== null;
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
        ?Carbon $satisfied = null,
        ?Carbon $completed = null,
        ?Carbon $revoked = null,
        ?Carbon $blocked = null,
        array $achievements = [],
        array $requirements = [],
    ): void {
        $this->cardId = CardId::of($cardId);
        $this->planId = PlanId::of($planId);
        $this->customerId = CustomerId::of($customerId);
        $this->description = Description::of($description);
        $this->issued = $issued;
        $this->satisfied = $satisfied;
        $this->completed = $completed;
        $this->revoked = $revoked;
        $this->blocked = $blocked;
        $this->achievements = Achievements::of(...$achievements);
        $this->requirements = Achievements::of(...$requirements);
    }
}
