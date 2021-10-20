<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;
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

    public function find(CollaboratorId $collaboratorId, WorkspaceId $workspaceId): Relation
    {
        /** @var EloquentRelation $eloquentRelation */
        $eloquentRelation = EloquentRelation::query()
            ->where('collaborator_id', '=', (string) $collaboratorId)
            ->where('workspace_id', '=', (string) $workspaceId)
            ->first();
        return $eloquentRelation ? $this->relationFromData($eloquentRelation) : throw new RelationNotFoundException();
    }

    private function relationAsData(Relation $relation): array
    {
        $reflection = new ReflectionClass($relation);
        $properties = [
            'relationType' => null,
            'established' => null,
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
            'established_at' => $properties['established'],
        ];

        return $data;
    }

    private function relationFromData(EloquentRelation $eloquentRelation): Relation
    {
        $relation = Relation::restore(
            $eloquentRelation->id,
            $eloquentRelation->collaborator_id,
            $eloquentRelation->workspace_id,
            $eloquentRelation->relation_type,
            $eloquentRelation->established_at,
        );
        return $relation;
    }
}
