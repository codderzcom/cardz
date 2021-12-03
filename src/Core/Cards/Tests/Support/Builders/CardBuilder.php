<?php

namespace Cardz\Core\Cards\Tests\Support\Builders;

use Carbon\Carbon;
use Cardz\Core\Cards\Domain\Model\Card\Achievement;
use Cardz\Core\Cards\Domain\Model\Card\Achievements;
use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Cardz\Core\Cards\Domain\Model\Card\CustomerId;
use Cardz\Core\Cards\Domain\Model\Plan\PlanId;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class CardBuilder extends BaseBuilder
{
    public string $cardId;

    public string $planId;

    public string $customerId;

    public string $description;

    public ?Carbon $issued = null;

    public ?Carbon $satisfied = null;

    public ?Carbon $completed = null;

    public ?Carbon $revoked = null;

    public ?Carbon $blocked = null;

    /**
     * @var Achievement[]
     */
    public array $achievements;

    /**
     * @var Achievement[]
     */
    public array $requirements;

    public function build(): Card
    {
        return Card::restore(
            $this->cardId,
            $this->planId,
            $this->customerId,
            $this->description,
            $this->issued,
            $this->satisfied,
            $this->completed,
            $this->revoked,
            $this->blocked,
            $this->achievements,
            $this->requirements,
        );
    }

    public function withRequirements(Requirement ... $requirements): self
    {
        $this->requirements = Achievements::from(...$requirements)->toArray();
        return $this;
    }

    public function withAchievements(Achievement ... $achievements): self
    {
        $achievementData = [];
        foreach ($achievements as $achievement) {
            $achievementData[] = $achievement->toArray();
        }
        $this->achievements = $achievementData;
        return $this;
    }

    public function withCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function withPlanId(string $planId): self
    {
        $this->planId = $planId;
        return $this;
    }

    public function generate(): static
    {
        $this->cardId = CardId::makeValue();
        $this->planId = PlanId::makeValue();
        $this->customerId = CustomerId::makeValue();
        $this->description = $this->faker->text();
        $this->issued = Carbon::now();
        $this->satisfied = null;
        $this->completed = null;
        $this->revoked = null;
        $this->blocked = null;
        $this->achievements = [];
        $this->requirements = [];
        return $this;
    }
}
