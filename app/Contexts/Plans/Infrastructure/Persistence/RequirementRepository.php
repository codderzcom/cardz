<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
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

    public function take(RequirementId $requirementId): ?Requirement
    {
        /** @var EloquentRequirement $eloquentRequirement */
        $eloquentRequirement = EloquentRequirement::query()->find((string) $requirementId);
        if ($eloquentRequirement === null) {
            return null;
        }
        return $this->requirementFromData($eloquentRequirement);
    }

    public function remove(Requirement $requirement): void
    {
        EloquentRequirement::query()->where('id', '=', $requirement->requirementId)->delete();
    }

    private function requirementAsData(Requirement $requirement): array
    {
        $reflection = new ReflectionClass($requirement);
        $properties = [
            'added' => null,
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
        ];
        return $data;
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
        );
        return $requirement;
    }
}
