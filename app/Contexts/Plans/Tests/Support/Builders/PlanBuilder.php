<?php

namespace App\Contexts\Plans\Tests\Support\Builders;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class PlanBuilder extends BaseBuilder
{
    public string $planId;

    public string $workspaceId;

    public string $description;

    public Carbon $added;

    public ?Carbon $launched;

    public ?Carbon $stopped;

    public ?Carbon $archived;

    public function build(): Plan
    {
        return Plan::restore(
            $this->planId,
            $this->workspaceId,
            $this->description,
            $this->added,
            $this->launched,
            $this->stopped,
            $this->archived,
        );
    }

    public function buildLaunched(): Plan
    {
        $this->launched = Carbon::now();
        return $this->build();
    }

    public function withWorkspaceId(string $workspaceId): self
    {
        $this->workspaceId = $workspaceId;
        return $this;
    }

    public function generate(): static
    {
        $this->planId = PlanId::makeValue();
        $this->workspaceId = WorkspaceId::makeValue();
        $this->description = $this->faker->text();
        $this->added = Carbon::now();
        $this->launched = null;
        $this->stopped = null;
        $this->archived = null;
        return $this;
    }
}
