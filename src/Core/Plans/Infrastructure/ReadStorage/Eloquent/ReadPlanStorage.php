<?php

namespace Cardz\Core\Plans\Infrastructure\ReadStorage\Eloquent;

use App\Models\Plan as EloquentPlan;
use App\Models\Requirement as EloquentRequirement;
use Cardz\Core\Plans\Domain\ReadModel\ReadPlan;
use Cardz\Core\Plans\Domain\ReadModel\ReadRequirement;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use JetBrains\PhpStorm\Pure;

class ReadPlanStorage implements ReadPlanStorageInterface
{
    public function take(?string $planId): ?ReadPlan
    {
        if ($planId === null) {
            return null;
        }
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()->where([
            'id' => $planId,
        ])?->first();
        if ($eloquentPlan === null) {
            return null;
        }
        $eloquentRequirements = EloquentRequirement::query()
                ->where('plan_id', '=', $planId)
                ->whereNull('removed_at')
                ->get() ?? [];

        return $this->readPlanFromData($eloquentPlan, ...$eloquentRequirements);
    }

    #[Pure]
    private function readPlanFromData(EloquentPlan $eloquentPlan, EloquentRequirement ...$eloquentRequirements): ReadPlan
    {
        $requirements = [];
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = new ReadRequirement(
                $eloquentRequirement->id,
                $eloquentRequirement->plan_id,
                $eloquentRequirement->description,
            );
        }
        return new ReadPlan(
            $eloquentPlan->id,
            $eloquentPlan->workspace_id,
            $eloquentPlan->description,
            $eloquentPlan->added_at !== null,
            $eloquentPlan->launched_at !== null,
            $eloquentPlan->stopped_at !== null,
            $eloquentPlan->archived_at !== null,
            $requirements,
        );
    }
}
