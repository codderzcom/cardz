<?php

namespace App\Contexts\Plans\Domain\Model\Requirement;

use App\Contexts\Plans\Domain\Events\Requirement\RequirementAdded;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementChanged;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Requirement extends AggregateRoot
{
    private ?Carbon $added = null;

    private ?Carbon $removed = null;

    private function __construct(
        public RequirementId $requirementId,
        public PlanId $planId,
        private Description $description,
    ) {
    }

    #[Pure]
    public static function make(RequirementId $requirementId, PlanId $planId, Description $description): self
    {
        return new self($requirementId, $planId, $description);
    }

    public function add(): RequirementAdded
    {
        $this->added = Carbon::now();
        return RequirementAdded::with($this->requirementId);
    }

    public function remove(): RequirementRemoved
    {
        $this->removed = Carbon::now();
        return RequirementRemoved::with($this->requirementId);
    }

    public function change(Description $description): RequirementChanged
    {
        $this->description = $description;
        return RequirementChanged::with($this->requirementId);
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    public function isRemoved(): bool
    {
        return $this->removed !== null;
    }

    private function from(
        string $requirementId,
        string $planId,
        string $description = null,
        ?Carbon $added = null,
        ?Carbon $removed = null,
    ): void {
        $this->requirementId = RequirementId::of($requirementId);
        $this->planId = PlanId::of($planId);
        $this->description = Description::of($description);
        $this->added = $added;
        $this->removed = $removed;
    }
}
