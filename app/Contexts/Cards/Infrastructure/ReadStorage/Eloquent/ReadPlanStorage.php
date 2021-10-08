<?php

namespace App\Contexts\Cards\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Cards\Domain\ReadModel\ReadPlan;
use App\Contexts\Cards\Domain\ReadModel\ReadRequirement;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use App\Models\Plan as EloquentPlan;
use App\Models\Requirement as EloquentRequirement;
use JetBrains\PhpStorm\Pure;

class ReadPlanStorage implements ReadPlanStorageInterface
{
    public function take(?string $planId): ?ReadPlan
    {
        if ($planId === null) {
            return null;
        }
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()
            ->where('id' , '=', $planId)
            ->whereNull('archived_at')
            ->whereNotNull('added_at')
            ->first();
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
            $eloquentPlan->launched_at !== null,
            $eloquentPlan->stopped_at !== null,
            $requirements,
        );
    }
}
