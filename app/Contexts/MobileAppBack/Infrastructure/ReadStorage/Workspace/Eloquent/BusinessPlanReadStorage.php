<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessPlan;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Infrastructure\Exceptions\BusinessPlanNotFoundException;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessPlanReadStorageInterface;
use App\Models\Plan as EloquentPlan;

class BusinessPlanReadStorage implements BusinessPlanReadStorageInterface
{
    public function find(string $planId): BusinessPlan
    {
        /** @var EloquentPlan $plan */
        $plan = EloquentPlan::query()->find($planId);
        if ($plan === null) {
            throw new BusinessPlanNotFoundException("Plan Id: $planId");
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

    private function planFromEloquent(EloquentPlan $plan): BusinessPlan
    {
        $requirements = [];
        $eloquentRequirements = $plan->requirements()->get();
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = [$eloquentRequirement->id, $eloquentRequirement->description];
        }
        return BusinessPlan::make(
            $plan->id,
            $plan->workspace_id,
            $plan->description,
            $requirements
        );
    }
}
