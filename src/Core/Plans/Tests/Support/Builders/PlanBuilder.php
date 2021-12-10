<?php

namespace Cardz\Core\Plans\Tests\Support\Builders;

use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class PlanBuilder extends BaseBuilder
{
    public string $planId;

    public string $workspaceId;

    public string $description;

    public Carbon $added;

    public ?Carbon $launched;

    public ?Carbon $stopped;

    public ?Carbon $archived;

    public ?Carbon $expirationDate;

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
            $this->expirationDate,
        );
    }

    public function withLaunched(?Carbon $launched = null, ?Carbon $expirationDate = null): self
    {
        $this->launched = $launched ?? Carbon::now();
        $this->expirationDate = $expirationDate ?? Carbon::now()->addDay();
        $this->stopped = null;
        return $this;
    }

    public function withStopped(?Carbon $stopped = null): self
    {
        $this->stopped = $stopped ?? Carbon::now();
        $this->launched = null;
        return $this;
    }

    public function withArchived(?Carbon $archived = null): self
    {
        $this->archived = $archived ?? Carbon::now();
        return $this;
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
        $this->expirationDate = null;
        return $this;
    }
}
