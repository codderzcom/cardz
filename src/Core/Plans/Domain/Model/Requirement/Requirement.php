<?php

namespace Cardz\Core\Plans\Domain\Model\Requirement;

use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementAdded;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementChanged;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementRemoved;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Codderz\Platypus\Contracts\Domain\AggregateRootInterface;
use Codderz\Platypus\Infrastructure\Support\Domain\AggregateRootTrait;

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
