<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Shared\Contracts\Domain\AggregateRootInterface;
use App\Shared\Infrastructure\Support\Domain\AggregateRootTrait;
use JetBrains\PhpStorm\Pure;

final class Workspace implements AggregateRootInterface
{
    use AggregateRootTrait;

    #[Pure]
    private function __construct(
        public WorkspaceId $workspaceId,
    ) {
    }

    #[Pure]
    public static function restore(WorkspaceId $workspaceId): self
    {
        return new self($workspaceId);
    }

    public function addPlan(PlanId $planId, Description $description): Plan
    {
        return Plan::add($planId, $this->workspaceId, $description);
    }
}
