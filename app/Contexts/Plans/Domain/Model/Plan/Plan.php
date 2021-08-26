<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Contexts\Plans\Domain\Events\Plan\PlanAdded;
use App\Contexts\Plans\Domain\Events\Plan\PlanArchived;
use App\Contexts\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use App\Contexts\Plans\Domain\Events\Plan\PlanLaunched;
use App\Contexts\Plans\Domain\Events\Plan\PlanStopped;
use App\Contexts\Plans\Domain\Model\Shared\WorkspaceId;
use Carbon\Carbon;

class Plan
{
    private ?Carbon $added = null;

    private ?Carbon $launched = null;

    private ?Carbon $stopped = null;

    private ?Carbon $archived = null;

    private function __construct(
        public PlanId $planId,
        public WorkspaceId $workspaceId,
        private ?string $description = null
    ) {
    }

    public function add(): PlanAdded
    {
        $this->added = Carbon::now();
        return PlanAdded::with($this->planId);
    }

    public function launch(): PlanLaunched
    {
        $this->launched = Carbon::now();
        return PlanLaunched::with($this->planId);
    }

    public function stop(): PlanStopped
    {
        $this->stopped = Carbon::now();
        return PlanStopped::with($this->planId);
    }

    public function archive(): PlanArchived
    {
        $this->archived = Carbon::now();
        return PlanArchived::with($this->planId);
    }

    public function changeDescription(?string $description): PlanDescriptionChanged
    {
        $this->description = $description;
        return PlanDescriptionChanged::with($this->planId);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isAdded(): bool
    {
        return $this->added === null;
    }

    public function isLaunched(): bool
    {
        return $this->launched === null;
    }

    public function isStopped(): bool
    {
        return $this->stopped === null;
    }

    public function isArchived(): bool
    {
        return $this->archived === null;
    }

}
