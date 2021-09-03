<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementCollection;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementIdCollection;
use App\Models\Requirement as EloquentRequirement;
use ReflectionClass;

class RequirementRepository implements RequirementRepositoryInterface
{
    public function persist(?Requirement $requirement): void
    {
        if ($requirement === null) {
            return;
        }

        EloquentRequirement::query()->updateOrCreate(
            ['id' => $requirement->requirementId],
            $this->requirementAsData($requirement)
        );
    }

    private function requirementAsData(Requirement $requirement): array
    {
        $reflection = new ReflectionClass($requirement);
        $properties = [
            'added' => null,
            'removed' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($requirement);
        }

        $data = [
            'id' => (string) $requirement->requirementId,
            'plan_id' => (string) $requirement->planId,
            'description' => (string) $requirement->getDescription(),
            'added_at' => $properties['added'],
            'removed_at' => $properties['removed'],
        ];
        return $data;
    }

    public function take(RequirementId $requirementId): ?Requirement
    {
        if ($requirementId === null) {
            return null;
        }
        /** @var EloquentRequirement $eloquentRequirement */
        $eloquentRequirement = EloquentRequirement::query()->where([
            'id' => (string) $requirementId,
        ])?->first();
        if ($eloquentRequirement === null) {
            return null;
        }
        return $this->requirementFromData($eloquentRequirement);
    }

    private function requirementFromData(EloquentRequirement $eloquentRequirement): Requirement
    {
        $reflection = new ReflectionClass(Requirement::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Requirement $requirement */
        $requirement = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($requirement,
            $eloquentRequirement->id,
            $eloquentRequirement->plan_id,
            $eloquentRequirement->description,
            $eloquentRequirement->added_at,
            $eloquentRequirement->removed_at,
        );
        return $requirement;
    }

    public function takeByRequirementIds(RequirementIdCollection $requirementIdCollection): RequirementCollection
    {
        $requirements = [];
        $eloquentRequirements = EloquentRequirement::query()->whereIn('id', $requirementIdCollection->toIds())->get();
        /** @var EloquentRequirement $eloquentRequirement */
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = $this->requirementFromData($eloquentRequirement);
        }
        return RequirementCollection::of(...$requirements);
    }

    public function takeByPlanId(PlanId $planId): RequirementCollection
    {
        $requirements = [];
        $eloquentRequirements = EloquentRequirement::query()->where('plan_id', '=', (string) $planId)->get();
        /** @var EloquentRequirement $eloquentRequirement */
        foreach ($eloquentRequirements as $eloquentRequirement) {
            $requirements[] = $this->requirementFromData($eloquentRequirement);
        }
        return RequirementCollection::of(...$requirements);
    }
}
