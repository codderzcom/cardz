<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\WorkspacePlan;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\WorkspacePlanReadStorageInterface;
use App\Models\Plan as EloquentPlan;
use App\Models\Requirement as EloquentRequirement;

class WorkspacePlanReadStorage implements WorkspacePlanReadStorageInterface
{
    public function find(string $planId): ?WorkspacePlan
    {
        /** @var EloquentPlan $plan */
        $plan = EloquentPlan::query()->find($planId);
        if ($plan === null) {
            return null;
        }
        $eloquentRequirements = EloquentRequirement::query()->where('plan_id', '=', $planId)->get() ?? [];

        return $this->planFromEloquent($plan, ...$eloquentRequirements);
    }

    private function planFromEloquent(EloquentPlan $plan, EloquentRequirement ...$eloquentRequirements): WorkspacePlan
    {
        $requirements = [];
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = [$eloquentRequirement->id, $eloquentRequirement->description];
        }
        return WorkspacePlan::make(
            $plan->id,
            $plan->workspace_id,
            $plan->description,
            $requirements
        );
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
}
