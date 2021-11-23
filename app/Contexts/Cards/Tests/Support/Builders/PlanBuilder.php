<?php

namespace App\Contexts\Cards\Tests\Support\Builders;

use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Contexts\Cards\Domain\Model\Plan\Requirement;
use App\Shared\Infrastructure\Tests\BaseBuilder;

final class PlanBuilder extends BaseBuilder
{
    public PlanId $planId;

    public string $description;

    /**
     * @var Requirement[]
     */
    public array $requirements = [];

    public function build(): Plan
    {
        return Plan::restore(
            $this->planId,
            $this->description,
            ...$this->requirements,
        );
    }

    public function withPlanId(PlanId $planId): self
    {
        $this->planId = $planId;
        return $this;
    }

    public function generate(): static
    {
        $this->planId = PlanId::make();
        $this->description = $this->faker->text();
        $this->requirements = $this->generateRequirements();
        return $this;
    }

    private function generateRequirements(int $quantity = 5): array
    {
        return RequirementBuilder::generateSeries($quantity);
    }
}
