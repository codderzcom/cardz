<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Events\Card\AchievementDescriptionFixed;
use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfactionWithdrawn;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfied;
use App\Contexts\Cards\Domain\Events\Card\CardUnblocked;
use App\Contexts\Cards\Domain\Events\Card\RequirementsAccepted;
use App\Contexts\Cards\Domain\Exceptions\InvalidCardStateException;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Card implements AggregateRootInterface
{
    use AggregateRootTrait;

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

    public static function issue(CardId $cardId, PlanId $planId, CustomerId $customerId, Description $description): self
    {
        $card = new self($cardId, $planId, $customerId, $description);

        $card->issued = Carbon::now();
        return $card->withEvents(CardIssued::of($card));
    }

    public static function restore(
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
    ): self {
        $card = new Card(
            CardId::of($cardId),
            PlanId::of($planId),
            CustomerId::of($customerId),
            Description::of($description),
        );
        $card->issued = $issued;
        $card->satisfied = $satisfied;
        $card->completed = $completed;
        $card->revoked = $revoked;
        $card->blocked = $blocked;
        $card->achievements = Achievements::of(...$achievements);
        $card->requirements = Achievements::of(...$requirements);
        return $card;
    }

    public function complete(): self
    {
        if ($this->isCompleted() || $this->isRevoked() || $this->isBlocked()) {
            throw new InvalidCardStateException();
        }

        $this->completed = Carbon::now();
        return $this->withEvents(CardCompleted::of($this));
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

    public function revoke(): self
    {
        if ($this->isRevoked() || $this->isCompleted()) {
            throw new InvalidCardStateException();
        }

        $this->revoked = Carbon::now();
        return $this->withEvents(CardRevoked::of($this));
    }

    public function block(): self
    {
        if ($this->isBlocked() || $this->isCompleted() || $this->isRevoked()) {
            throw new InvalidCardStateException();
        }

        $this->blocked = Carbon::now();
        return $this->withEvents(CardBlocked::of($this));
    }

    public function unblock(): self
    {
        if (!$this->isBlocked() || $this->isRevoked()) {
            throw new InvalidCardStateException();
        }

        $this->blocked = null;
        return $this->withEvents(CardUnblocked::of($this));
    }

    public function noteAchievement(Achievement $achievement): self
    {
        if ($this->isSatisfied() || $this->isCompleted() || $this->isBlocked() || $this->isRevoked()) {
            throw new InvalidCardStateException();
        }

        $this->achievements = $this->achievements->add($achievement);
        return $this->withEvents(AchievementNoted::of($this))->tryToSatisfy();
    }

    public function isSatisfied(): bool
    {
        return $this->satisfied !== null;
    }

    private function tryToSatisfy(): self
    {
        $requirements = $this->requirements->filterRemaining($this->achievements);
        if ($requirements->isEmpty()) {
            $this->satisfied = Carbon::now();
            return $this->withEvents(CardSatisfied::of($this));
        }
        return $this;
    }

    public function dismissAchievement(string $achievementId): self
    {
        if ($this->isCompleted() || $this->isBlocked() || $this->isRevoked()) {
            throw new InvalidCardStateException();
        }

        $this->achievements = $this->achievements->removeById($achievementId);
        return $this->withEvents(AchievementDismissed::of($this))->tryToWithdrawSatisfaction();
    }

    private function tryToWithdrawSatisfaction(): self
    {
        if (!$this->isSatisfied()) {
            return $this;
        }

        $requirements = $this->requirements->filterRemaining($this->achievements);
        if (!$requirements->isEmpty()) {
            $this->satisfied = null;
            return $this->withEvents(CardSatisfactionWithdrawn::of($this));
        }

        return $this;
    }

    public function acceptRequirements(Achievements $requirements): self
    {
        if ($this->isSatisfied() || $this->isCompleted() || $this->isRevoked()) {
            throw new InvalidCardStateException();
        }

        $this->requirements = $requirements;
        return $this->withEvents(RequirementsAccepted::of($this))->tryToSatisfy();
    }

    public function fixAchievementDescription(Achievement $achievement): self
    {
        $this->achievements = $this->achievements->replace($achievement);
        $this->requirements = $this->requirements->replace($achievement);
        return $this->withEvents(AchievementDescriptionFixed::of($this));
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

}
