<?php

namespace App\Contexts\Cards\Tests\Support\Builders;

use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Model\Card\CustomerId;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class CardBuilder extends BaseBuilder
{
    private string $cardId;

    private string $planId;

    private string $customerId;

    private string $description;

    private ?Carbon $issued = null;

    private ?Carbon $satisfied = null;

    private ?Carbon $completed = null;

    private ?Carbon $revoked = null;

    private ?Carbon $blocked = null;

    /**
     * @var Achievement[]
     */
    private array $achievements;

    /**
     * @var Achievement[]
     */
    private array $requirements;

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
