<?php

namespace App\Contexts\Plans\Domain\Model\Requirement;

use App\Contexts\Plans\Domain\Events\Requirement\RequirementAdded;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementChanged;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use Carbon\Carbon;

final class Requirement implements AggregateRootInterface
{
    use AggregateRootTrait;

    private ?Carbon $added = null;

    private ?Carbon $removed = null;

    private function __construct(
        public RequirementId $requirementId,
        public PlanId $planId,
        private string $description,
    ) {
    }

    public static function add(RequirementId $requirementId, PlanId $planId, string $description): self
    {
        $requirement = new self($requirementId, $planId, $description);
        $requirement->added = Carbon::now();
        return $requirement->withEvents(RequirementAdded::of($requirement));
    }

    public static function restore(string $requirementId, string $planId, string $description, ?Carbon $added, ?Carbon $removed): self
    {
        $requirement = new self(RequirementId::of($requirementId), PlanId::of($planId), $description);
        $requirement->added = $added;
        $requirement->removed = $removed;
        return $requirement;
    }

    public function remove(): self
    {
        $this->removed = Carbon::now();
        return $this->withEvents(RequirementRemoved::of($this));
    }

    public function change(string $description): self
    {
        $this->description = $description;
        return $this->withEvents(RequirementChanged::of($this));
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    public function isRemoved(): bool
    {
        return $this->removed !== null;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
