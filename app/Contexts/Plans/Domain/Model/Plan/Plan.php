<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Contexts\Plans\Domain\Events\Plan\PlanAdded;
use App\Contexts\Plans\Domain\Events\Plan\PlanArchived;
use App\Contexts\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use App\Contexts\Plans\Domain\Events\Plan\PlanLaunched;
use App\Contexts\Plans\Domain\Events\Plan\PlanStopped;
use App\Contexts\Plans\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use App\Contexts\Plans\Domain\Model\Shared\WorkspaceId;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Plan extends AggregateRoot
{
    private ?Carbon $added = null;

    private ?Carbon $launched = null;

    private ?Carbon $stopped = null;

    private ?Carbon $archived = null;

    #[Pure]
    private function __construct(
        public PlanId $planId,
        public WorkspaceId $workspaceId,
        private Description $description,
    ) {
        $this->requirements = Requirements::of();
    }

    #[Pure]
    public static function make(PlanId $planId, WorkspaceId $workspaceId, Description $description = null): self
    {
        return new self($planId, $workspaceId, $description);
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

    public function changeDescription(Description $description): PlanDescriptionChanged
    {
        $this->description = $description;
        return PlanDescriptionChanged::with($this->planId);
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    public function isLaunched(): bool
    {
        return $this->launched !== null;
    }

    public function isStopped(): bool
    {
        return $this->stopped !== null;
    }

    public function isArchived(): bool
    {
        return $this->archived !== null;
    }

    private function from(
        string $planId,
        string $workspaceId,
        string $description,
        ?Carbon $added = null,
        ?Carbon $launched = null,
        ?Carbon $stopped = null,
        ?Carbon $archived = null,
    ): void {
        $this->planId = PlanId::of($planId);
        $this->workspaceId = WorkspaceId::of($workspaceId);
        $this->description = Description::of($description);
        $this->added = $added;
        $this->launched = $launched;
        $this->stopped = $stopped;
        $this->archived = $archived;
    }
}
