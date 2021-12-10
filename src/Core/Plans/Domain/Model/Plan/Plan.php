<?php

namespace Cardz\Core\Plans\Domain\Model\Plan;

use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Events\Plan\PlanAdded;
use Cardz\Core\Plans\Domain\Events\Plan\PlanArchived;
use Cardz\Core\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use Cardz\Core\Plans\Domain\Events\Plan\PlanLaunched;
use Cardz\Core\Plans\Domain\Events\Plan\PlanStopped;
use Cardz\Core\Plans\Domain\Exceptions\InvalidPlanStateException;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;
use JetBrains\PhpStorm\Pure;

final class Plan implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $added = null;

    private ?Carbon $launched = null;

    private ?Carbon $stopped = null;

    private ?Carbon $archived = null;

    private ?Carbon $expirationDate = null;

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
        ?Carbon $expirationDate = null,
    ): self {
        $plan = new self(PlanId::of($planId), WorkspaceId::of($workspaceId), Description::of($description));
        $plan->added = $added;
        $plan->launched = $launched;
        $plan->stopped = $stopped;
        $plan->archived = $archived;
        $plan->expirationDate = $expirationDate;
        return $plan;
    }

    public function addRequirement(RequirementId $requirementId, string $description): Requirement
    {
        if ($this->isArchived()) {
            throw new InvalidPlanStateException();
        }
        return Requirement::add($requirementId, $this->planId, $description);
    }

    public function launch(Carbon $expirationDate): self
    {
        if ($this->isArchived()) {
            throw new InvalidPlanStateException();
        }

        $this->launched = Carbon::now();
        $this->expirationDate = $expirationDate;

        if ($this->expirationDate->lessThan($this->launched)) {
            throw new InvalidPlanStateException();
        }

        $this->stopped = null;
        return $this->withEvents(PlanLaunched::of($this));
    }

    public function stop(): self
    {
        if ($this->isStopped() || $this->isArchived()) {
            throw new InvalidPlanStateException();
        }
        $this->stopped = Carbon::now();
        $this->launched = null;
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
        return $this->launched !== null && $this->stopped === null;
    }

    public function isStopped(): bool
    {
        return $this->stopped !== null && $this->launched === null;
    }

    public function isArchived(): bool
    {
        return $this->archived !== null;
    }
}
