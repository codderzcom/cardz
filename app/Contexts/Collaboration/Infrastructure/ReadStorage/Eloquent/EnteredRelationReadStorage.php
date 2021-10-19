<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\ReadModel\EnteredRelation;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\EnteredRelationReadStorageInterface;
use App\Models\Relation as EloquentRelation;

class EnteredRelationReadStorage implements EnteredRelationReadStorageInterface
{
    public function take(string $relationId): ?EnteredRelation
    {
        $eloquentRelation = EloquentRelation::query()
            ->where('id', '=', $relationId)
            ->whereNotNull('entered_at')
            ->whereNull('left_at')
            ->first();
        if ($eloquentRelation === null) {
            return null;
        }
        return new EnteredRelation(
            RelationId::of($eloquentRelation->id),
            CollaboratorId::of($eloquentRelation->collaborator_id),
            WorkspaceId::of($eloquentRelation->workspace_id),
            RelationType::of($eloquentRelation->relation_type),
        );
    }

}
