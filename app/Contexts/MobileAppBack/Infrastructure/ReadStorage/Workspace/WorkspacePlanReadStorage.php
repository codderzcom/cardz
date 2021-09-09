<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\WorkspacePlan;
use App\Models\Plan as EloquentPlan;

class WorkspacePlanReadStorage implements WorkspacePlanReadStorageInterface
{
    public function find(string $planId): ?WorkspacePlan
    {
        /** @var EloquentPlan $plan */
        $plan = EloquentPlan::query()->find($planId);
        if ($plan === null) {
            return null;
        }

        return $this->planFromEloquent($plan);
    }

    /**
     * @return BusinessWorkspace[]
     */
    public function allForWorkspace(string $workspaceId): array
    {
        $plans = EloquentPlan::query()
            ->where('workspace_id', '=', $workspaceId)
            ->get();
        $workspacePlans = [];
        foreach ($plans as $plan) {
            $workspacePlans[] = $this->planFromEloquent($plan);
        }

        return $workspacePlans;
    }

    private function planFromEloquent(EloquentPlan $plan): WorkspacePlan
    {
        $requirements = is_string($plan->requirements) ? json_try_decode($plan->requiremets) : $plan->requirements;

        return WorkspacePlan::make(
            $plan->id,
            $plan->workspace_id,
            $plan->description,
            $requirements
        );
    }
}
