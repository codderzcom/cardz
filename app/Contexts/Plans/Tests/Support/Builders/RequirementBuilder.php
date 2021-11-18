<?php

namespace App\Contexts\Plans\Tests\Support\Builders;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class RequirementBuilder extends BaseBuilder
{
    private string $requirementId;

    private string $planId;

    private string $description;

    private Carbon $added;

    private ?Carbon $removed;

    public function build(): Requirement
    {
        return Requirement::restore(
            $this->requirementId,
            $this->planId,
            $this->description,
            $this->added,
            $this->removed,
        );
    }

    public function generate(): static
    {
        $this->requirementId = RequirementId::makeValue();
        $this->planId = PlanId::makeValue();
        $this->description = $this->faker->text();
        $this->added = Carbon::now();
        $this->removed = null;
        return $this;
    }
}
