<?php

namespace App\Contexts\Plans\Infrastructure\ReadStorage;

use App\Contexts\Plans\Application\Contracts\ReadPlanStorageInterface;
use App\Contexts\Plans\Domain\ReadModel\ReadPlan;
use App\Models\Plan as EloquentPlan;
use App\Models\Requirement as EloquentRequirement;
use function json_try_decode;

class ReadPlanStorage implements ReadPlanStorageInterface
{
    public function take(string $planId): ?ReadPlan
    {
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()->where([
            'id' => $planId,
        ])?->first();
        if ($eloquentPlan === null) {
            return null;
        }
        $eloquentRequirements = EloquentRequirement::query()->where('plan_id', '=', $planId)->get() ?? [];

        return $this->readPlanFromData($eloquentPlan, ...$eloquentRequirements);
    }

    private function readPlanFromData(EloquentPlan $eloquentPlan, EloquentRequirement ...$eloquentRequirements): ReadPlan
    {
        $requirements = is_string($eloquentPlan->requirements) ? json_try_decode($eloquentPlan->requirements) : $eloquentPlan->requirements;
        return new ReadPlan(
            $eloquentPlan->id,
            $eloquentPlan->workspace_id,
            $eloquentPlan->description,
            $requirements,
            $eloquentPlan->added_at !== null,
            $eloquentPlan->launched_at !== null,
            $eloquentPlan->stopped_at !== null,
            $eloquentPlan->archived_at !== null,
        );
    }
}
