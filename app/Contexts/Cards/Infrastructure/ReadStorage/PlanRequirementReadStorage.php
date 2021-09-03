<?php

namespace App\Contexts\Cards\Infrastructure\ReadStorage;

use App\Contexts\Cards\Application\Contracts\PlanRequirementReadStorageInterface;
use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use App\Contexts\Cards\Domain\Model\Shared\PlanId;
use App\Contexts\Cards\Domain\ReadModel\PlanRequirement;
use App\Contexts\Cards\Domain\ReadModel\PlanRequirementsCollection;
use App\Models\Requirement as EloquentRequirement;

class PlanRequirementReadStorage implements PlanRequirementReadStorageInterface
{
    public function find(RequirementId $requirementId): ?PlanRequirement
    {
        /** @var EloquentRequirement $requirement */
        $requirement = EloquentRequirement::query()->find((string) $requirementId);
        if ($requirement === null) {
            return null;
        }

        return $this->planRequirementFromData($requirement);
    }

    public function allByPlanId(PlanId $planId): PlanRequirementsCollection
    {
        $requirements = EloquentRequirement::query()
            ->where('plan_id', '=', (string) $planId)
            ->get();

        $planRequirements = [];

        foreach ($requirements as $requirement) {
            $planRequirements[] = $this->planRequirementFromData($requirement);
        }
        return PlanRequirementsCollection::of(...$planRequirements);
    }

    private function planRequirementFromData(EloquentRequirement $eloquentRequirement): PlanRequirement
    {
        return PlanRequirement::make(
            $eloquentRequirement->id,
            $eloquentRequirement->description,
        );
    }
}
