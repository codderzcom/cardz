<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Eloquent;

use App\Contexts\Plans\Application\Exceptions\PlanNotFoundException;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Models\Plan as EloquentPlan;
use ReflectionClass;

class PlanRepository implements PlanRepositoryInterface
{
    public function persist(Plan $plan): void
    {
        EloquentPlan::query()->updateOrCreate(
            ['id' => $plan->planId],
            $this->planAsData($plan)
        );
    }

    public function take(PlanId $planId): Plan
    {
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()->where([
            'id' => (string) $planId,
            'archived_at' => null,
        ])?->first();

        if ($eloquentPlan === null) {
            throw  new PlanNotFoundException();
        }

        return $this->planFromData($eloquentPlan);
    }

    private function planAsData(Plan $plan): array
    {
        $reflection = new ReflectionClass($plan);
        $properties = [
            'added' => null,
            'launched' => null,
            'stopped' => null,
            'archived' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($plan);
        }

        $data = [
            'id' => (string) $plan->planId,
            'workspace_id' => (string) $plan->workspaceId,
            'description' => (string) $plan->getDescription(),
            'added_at' => $properties['added'],
            'launched_at' => $properties['launched'],
            'stopped_at' => $properties['stopped'],
            'archived_at' => $properties['archived'],
        ];
        return $data;
    }

    private function planFromData(EloquentPlan $eloquentPlan): Plan
    {
        return Plan::restore(
            $eloquentPlan->id,
            $eloquentPlan->workspace_id,
            $eloquentPlan->description,
            $eloquentPlan->added_at,
            $eloquentPlan->launched_at,
            $eloquentPlan->stopped_at,
            $eloquentPlan->archived_at,
        );
    }
}
