<?php

namespace Cardz\Core\Plans\Infrastructure\Persistence\Eloquent;

use App\Models\Plan as EloquentPlan;
use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Exceptions\PlanNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape([
        'id' => "string",
        'workspace_id' => "string",
        'description' => "string",
        'added_at' => Carbon::class | null,
        'launched_at' => Carbon::class | null,
        'stopped_at' => Carbon::class | null,
        'archived_at' => Carbon::class | null,
        'expiration_date' => Carbon::class | null,
    ])]
    private function planAsData(Plan $plan): array
    {
        $properties = $this->extractProperties($plan, 'added', 'launched', 'stopped', 'archived', 'expirationDate');
        return [
            'id' => (string) $plan->planId,
            'workspace_id' => (string) $plan->workspaceId,
            'description' => (string) $plan->getDescription(),
            'added_at' => $properties['added'],
            'launched_at' => $properties['launched'],
            'stopped_at' => $properties['stopped'],
            'archived_at' => $properties['archived'],
            'expiration_date' => $properties['expirationDate'],
        ];
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
            $eloquentPlan->expiration_date,
        );
    }
}
