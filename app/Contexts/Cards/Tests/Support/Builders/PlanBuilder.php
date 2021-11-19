<?php

namespace App\Contexts\Cards\Tests\Support\Builders;

use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Contexts\Cards\Domain\Model\Plan\Requirement;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;
use App\Shared\Infrastructure\Tests\BaseBuilder;

final class PlanBuilder extends BaseBuilder
{
    private PlanId $planId;

    private string $description;

    /**
     * @var Requirement[]
     */
    private array $requirements = [];

    public function build(): Plan
    {
        return Plan::restore(
            $this->planId,
            $this->description,
            ...$this->requirements,
        );
    }

    public function buildForId(PlanId $planId): Plan
    {
        return Plan::restore(
            $planId,
            $this->description,
            ...$this->requirements,
        );
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
