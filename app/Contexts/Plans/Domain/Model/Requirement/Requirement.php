<?php

namespace App\Contexts\Plans\Domain\Model\Requirement;

use App\Contexts\Plans\Domain\Events\Requirement\RequirementAdded;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementChanged;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\AggregateRoot;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Requirement extends AggregateRoot
{
    private ?Carbon $added = null;

    private function __construct(
        public RequirementId $requirementId,
        public PlanId $planId,
        private string $description,
    ) {
    }

    #[Pure]
    public static function make(RequirementId $requirementId, PlanId $planId, string $description): self
    {
        return new self($requirementId, $planId, $description);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function add(): RequirementAdded
    {
        $this->added = Carbon::now();
        return RequirementAdded::with($this->requirementId);
    }

    public function remove(): RequirementRemoved
    {
        return RequirementRemoved::with($this->requirementId);
    }

    public function change(string $description): RequirementChanged
    {
        $this->description = $description;
        return RequirementChanged::with($this->requirementId);
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    private function from(
        string $requirementId,
        string $planId,
        string $description,
        ?Carbon $added,
    ): void {
        $this->requirementId = RequirementId::of($requirementId);
        $this->planId = PlanId::of($planId);
        $this->description = $description;
        $this->added = $added;
    }
}
