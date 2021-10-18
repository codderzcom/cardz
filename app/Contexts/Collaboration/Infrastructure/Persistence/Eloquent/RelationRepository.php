<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Models\Relation as EloquentRelation;
use ReflectionClass;

class RelationRepository implements RelationRepositoryInterface
{
    public function persist(Relation $relation): void
    {
        EloquentRelation::query()->updateOrCreate(
            ['id' => $relation->relationId],
            $this->relationAsData($relation)
        );
    }

    public function take(RelationId $relationId = null): ?Relation
    {
        /** @var EloquentRelation $eloquentRelation */
        $eloquentRelation = EloquentRelation::query()->find((string) $relationId);
        if ($eloquentRelation === null) {
            return null;
        }
        return $this->relationFromData($eloquentRelation);
    }

    private function relationAsData(Relation $relation): array
    {
        $reflection = new ReflectionClass($relation);
        $properties = [
            'relationType' => null,
            'entered' => null,
            'left' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($relation);
        }

        $data = [
            'id' => (string) $relation->relationId,
            'collaborator_id' => (string) $relation->collaboratorId,
            'workspace_id' => (string) $relation->workspaceId,
            'relation_type' => (string) $properties['relationType'],
            'entered_at' => $properties['entered'],
            'left_at' => $properties['left'],
        ];

        return $data;
    }

    private function relationFromData(EloquentRelation $eloquentRelation): Relation
    {
        $reflection = new ReflectionClass(Relation::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Relation $relation */
        $relation = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($relation,
            $eloquentRelation->id,
            $eloquentRelation->collaborator_id,
            $eloquentRelation->workspace_id,
            $eloquentRelation->relation_type,
            $eloquentRelation->entered_at,
            $eloquentRelation->left_at,
        );
        return $relation;
    }
}
