<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Models\Plan;

final class PlanProvider extends BaseConcreteObjectProvider
{
    use EloquentProviderTrait, RelationTrait;

    protected function getAttributes(): array
    {
        $plan = $this->getEloquentModel(Plan::query(), $this->objectId);
        $relations = $this->getRelations($plan->workspace_id);
        return [
            'planId' => $plan->id,
            'workspaceId' => $plan->id,
            'keeperId' => $this->getKeeperId($relations),
            'memberIds' => $this->getMemberIds($relations),
            'isActive' => $plan->launched_at !== null && $plan->stopped_at === null && $plan->archived_at === null,
        ];
    }
}
