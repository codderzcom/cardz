<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Contexts\Plans\Domain\Events\Plan\PlanAdded;
use App\Contexts\Plans\Domain\Events\Plan\PlanArchived;
use App\Contexts\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use App\Contexts\Plans\Domain\Events\Plan\PlanLaunched;
use App\Contexts\Plans\Domain\Events\Plan\PlanStopped;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Plan implements AggregateRootInterface
{
    use AggregateRootTrait;

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
    }

    public static function add(PlanId $planId, WorkspaceId $workspaceId, Description $description = null): self
    {
        $plan = new self($planId, $workspaceId, $description);
        $plan->added = Carbon::now();
        return $plan->withEvents(PlanAdded::of($plan));
    }

    public static function restore(
        string $planId,
        string $workspaceId,
        string $description,
        ?Carbon $added = null,
        ?Carbon $launched = null,
        ?Carbon $stopped = null,
        ?Carbon $archived = null,
    ): self {
        $plan = new self(PlanId::of($planId), WorkspaceId::of($workspaceId), Description::of($description));
        $plan->added = $added;
        $plan->launched = $launched;
        $plan->stopped = $stopped;
        $plan->archived = $archived;
        return $plan;
    }

    public function addRequirement(RequirementId $requirementId, string $description): Requirement
    {
        return Requirement::add($requirementId, $this->planId, $description);
    }

    public function launch(): self
    {
        $this->launched = Carbon::now();
        return $this->withEvents(PlanLaunched::of($this));
    }

    public function stop(): self
    {
        $this->stopped = Carbon::now();
        return $this->withEvents(PlanStopped::of($this));
    }

    public function archive(): self
    {
        $this->archived = Carbon::now();
        return $this->withEvents(PlanArchived::of($this));
    }

    public function changeDescription(Description $description): self
    {
        $this->description = $description;
        return $this->withEvents(PlanDescriptionChanged::of($this));
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
}
