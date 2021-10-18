<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Eloquent;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Exceptions\RequirementNotFoundException;
use App\Models\Requirement as EloquentRequirement;
use ReflectionClass;

class RequirementRepository implements RequirementRepositoryInterface
{
    public function persist(Requirement $requirement): void
    {
        EloquentRequirement::query()->updateOrCreate(
            ['id' => $requirement->requirementId],
            $this->requirementAsData($requirement)
        );
    }

    public function take(RequirementId $requirementId): Requirement
    {
        /** @var EloquentRequirement $eloquentRequirement */
        $eloquentRequirement = EloquentRequirement::query()->find((string) $requirementId);
        if ($eloquentRequirement === null) {
            throw new RequirementNotFoundException((string) $requirementId);
        }
        return $this->requirementFromData($eloquentRequirement);
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
            'description' => $requirement->getDescription(),
            'added_at' => $properties['added'],
            'removed_at' => $properties['removed'],
        ];
        return $data;
    }

    private function requirementFromData(EloquentRequirement $eloquentRequirement): Requirement
    {
        return Requirement::restore(
            $eloquentRequirement->id,
            $eloquentRequirement->plan_id,
            $eloquentRequirement->description,
            $eloquentRequirement->added_at,
            $eloquentRequirement->removed_at,
        );
    }
}
