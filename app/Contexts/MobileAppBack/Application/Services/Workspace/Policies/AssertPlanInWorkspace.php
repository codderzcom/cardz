<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Domain\Model\Workspace\PlanId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Models\Plan as EloquentPlan;
use App\Shared\Contracts\PolicyAssertionInterface;
use App\Shared\Contracts\PolicyViolationInterface;
use App\Shared\Infrastructure\Policy\PolicyViolation;
use JetBrains\PhpStorm\Pure;

final class AssertPlanInWorkspace implements PolicyAssertionInterface
{
    private function __construct(
        private PlanId $planId,
        private WorkspaceId $workspaceId,
    ) {
    }

    #[Pure]
    public static function of(PlanId $planId, WorkspaceId $workspaceId): self
    {
        return new self($planId, $workspaceId);
    }

    public function assert(): bool
    {
        $plan = EloquentPlan::query()
            ->where('id', '=', (string) $this->planId)
            ->where('workspace_id', '=', (string) $this->workspaceId)
            ->first();
        return $plan !== null;
    }

    public function violation(): PolicyViolationInterface
    {
        return PolicyViolation::of("Plan {$this->planId} is not in workspace {$this->workspaceId}");
    }

}
