<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Models\Plan as EloquentPlan;
use ReflectionClass;

class PlanRepository implements PlanRepositoryInterface
{
    public function persist(?Plan $plan): void
    {
        if ($plan === null) {
            return;
        }

        EloquentPlan::query()->updateOrCreate(
            ['id' => $plan->planId],
            $this->planAsData($plan)
        );
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

    public function take(PlanId $planId): ?Plan
    {
        /** @var EloquentPlan $eloquentPlan */
        $eloquentPlan = EloquentPlan::query()->where([
            'id' => (string) $planId,
            'archived_at' => null,
        ])?->first();
        if ($eloquentPlan === null) {
            return null;
        }
        return $this->planFromData($eloquentPlan);
    }

    private function planFromData(EloquentPlan $eloquentPlan): Plan
    {
        $reflection = new ReflectionClass(Plan::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Plan $plan */
        $plan = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($plan,
            $eloquentPlan->id,
            $eloquentPlan->workspace_id,
            $eloquentPlan->description,
            $eloquentPlan->added_at,
            $eloquentPlan->launched_at,
            $eloquentPlan->stopped_at,
            $eloquentPlan->archived_at,
        );
        return $plan;
    }
}
