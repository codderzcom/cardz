<?php

namespace Cardz\Core\Plans\Domain\Model\Plan;

use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Events\Plan\PlanAdded;
use Cardz\Core\Plans\Domain\Events\Plan\PlanArchived;
use Cardz\Core\Plans\Domain\Events\Plan\PlanProfileChanged;
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
        private Profile $profile,
    ) {
    }

    public static function add(PlanId $planId, WorkspaceId $workspaceId, Profile $profile): self
    {
        $plan = new self($planId, $workspaceId, $profile);
        $plan->added = Carbon::now();
        return $plan->withEvents(PlanAdded::of($plan));
    }

    public static function restore(
        string $planId,
        string $workspaceId,
        string $name,
        string $description,
        ?Carbon $added = null,
        ?Carbon $launched = null,
        ?Carbon $stopped = null,
        ?Carbon $archived = null,
        ?Carbon $expirationDate = null,
    ): self {
        $plan = new self(PlanId::of($planId), WorkspaceId::of($workspaceId), Profile::of($name, $description));
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

    public function changeProfile(Profile $profile): self
    {
        $this->profile = $profile;
        return $this->withEvents(PlanProfileChanged::of($this));
    }

    public function getProfile(): Profile
    {
        return $this->profile;
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
