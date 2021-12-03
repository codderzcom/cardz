<?php

namespace Cardz\Core\Plans\Infrastructure\Persistence\Eloquent;

use App\Models\Plan as EloquentPlan;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Exceptions\PlanNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;

class PlanRepository implements PlanRepositoryInterface
{
    use PropertiesExtractorTrait;

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
        $properties = $this->extractProperties($plan, 'added', 'launched', 'stopped', 'archived');
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
