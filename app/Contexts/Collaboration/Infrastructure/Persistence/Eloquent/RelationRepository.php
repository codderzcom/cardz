<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;
use App\Models\Relation as EloquentRelation;
use App\Shared\Infrastructure\Support\PropertiesExtractorTrait;

class RelationRepository implements RelationRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(Relation $relation): void
    {
        $relationId = (string) $relation->relationId;
        if ($relation->isLeft()) {
            EloquentRelation::query()->where('id', '=', $relationId)->delete();
            return;
        }
        EloquentRelation::query()->updateOrCreate(
            ['id' => $relationId],
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
        $data = [
            'id' => (string) $relation->relationId,
            'collaborator_id' => (string) $relation->collaboratorId,
            'workspace_id' => (string) $relation->workspaceId,
            'relation_type' => (string) $relation->relationType,
            'established_at' => $this->extractProperty($relation, 'established'),
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
            null,
        );
        return $relation;
    }
}
