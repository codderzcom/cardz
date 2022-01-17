<?php

namespace Cardz\Support\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Models\Relation as EloquentRelation;
use Carbon\Carbon;
use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape([
        'id' => "string",
        'collaborator_id' => "string",
        'workspace_id' => "string",
        'relation_type' => "string",
        'established_at' => Carbon::class | null,
    ])]
    private function relationAsData(Relation $relation): array
    {
        return [
            'id' => (string) $relation->relationId,
            'collaborator_id' => (string) $relation->collaboratorId,
            'workspace_id' => (string) $relation->workspaceId,
            'relation_type' => (string) $relation->relationType,
            'established_at' => $this->extractProperty($relation, 'established'),
        ];
    }

    private function relationFromData(EloquentRelation $eloquentRelation): Relation
    {
        return Relation::restore(
            $eloquentRelation->id,
            $eloquentRelation->collaborator_id,
            $eloquentRelation->workspace_id,
            $eloquentRelation->relation_type,
            $eloquentRelation->established_at,
            null,
        );
    }
}
