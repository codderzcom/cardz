<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Models\Plan as EloquentPlan;
use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessPlan;
use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessWorkspace;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessPlanNotFoundException;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts\BusinessPlanReadStorageInterface;

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
            if ($eloquentRequirement->removed_at === null) {
                $requirements[] = [
                    'requirementId' => $eloquentRequirement->id,
                    'description' => $eloquentRequirement->description,
                ];
            }
        }
        $profile = is_string($plan->profile) ? json_try_decode($plan->profile, true) : $plan->profile;

        return BusinessPlan::make(
            $plan->id,
            $plan->workspace_id,
            $profile['name'],
            $profile['description'],
            $plan->launched_at !== null,
            $plan->stopped_at !== null,
            $plan->archived_at !== null,
            $plan->expiration_date,
            $requirements
        );
    }
}
