<?php

namespace Cardz\Core\Cards\Tests\Support\Builders;

use Cardz\Core\Cards\Domain\Model\Plan\Plan;
use Cardz\Core\Cards\Domain\Model\Plan\PlanId;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class PlanBuilder extends BaseBuilder
{
    public PlanId $planId;

    public string $name;

    public string $description;

    /**
     * @var Requirement[]
     */
    public array $requirements = [];

    public function build(): Plan
    {
        return Plan::restore(
            $this->planId,
            $this->name,
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
        $this->name = $this->faker->sentence();
        $this->description = $this->faker->text();
        $this->requirements = $this->generateRequirements();
        return $this;
    }

    private function generateRequirements(int $quantity = 5): array
    {
        return RequirementBuilder::generateSeries($quantity);
    }
}
