<?php

namespace Cardz\Core\Cards\Infrastructure\Persistence\Eloquent;

use App\Models\Plan as EloquentPlan;
use App\Models\Requirement as EloquentRequirement;
use Cardz\Core\Cards\Domain\Model\Plan\Plan;
use Cardz\Core\Cards\Domain\Model\Plan\PlanId;
use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Cardz\Core\Cards\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Cards\Infrastructure\Exceptions\PlanNotFoundException;

class PlanRepository implements PlanRepositoryInterface
{
    public function take(PlanId $planId): Plan
    {
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()
            ->where('id', '=', $planId)
            ->whereNull('archived_at')
            ->whereNotNull('added_at')
            ->first();
        if ($eloquentPlan === null) {
            throw new PlanNotFoundException((string) $planId);
        }

        $eloquentRequirements = EloquentRequirement::query()
                ->where('plan_id', '=', $planId)
                ->whereNull('removed_at')
                ->get() ?? [];

        return $this->planFromData($eloquentPlan, ...$eloquentRequirements);
    }

    private function planFromData(EloquentPlan $eloquentPlan, EloquentRequirement ...$eloquentRequirements): Plan
    {
        $requirements = [];
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = Requirement::of(
                $eloquentRequirement->id,
                $eloquentRequirement->description,
            );
        }
        return Plan::restore(
            $eloquentPlan->id,
            $eloquentPlan->description,
            ...$requirements,
        );
    }

}
