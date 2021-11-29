<?php

namespace App\Contexts\Cards\Tests\Support\Builders;

use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Domain\Model\Card\Achievements;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Model\Card\CustomerId;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Contexts\Cards\Domain\Model\Plan\Requirement;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

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
