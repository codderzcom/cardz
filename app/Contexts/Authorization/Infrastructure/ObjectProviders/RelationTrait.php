<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Contexts\Authorization\Exceptions\AuthorizationFailedException;
use App\Models\Relation;

trait RelationTrait
{
    protected function getRelations(string $workspaceId): array
    {
        $relations = Relation::query()->where('workspace_id', '=', $workspaceId)->get();
        return $this->reconstructRelations($relations->toArray());
    }

    protected function reconstructRelations(array $relationsData): array
    {
        $relations = [];
        foreach ($relationsData as $relationData) {
            $relations[] = [
                'relationId' => $relationData['id'],
                'collaboratorId' => $relationData['collaborator_id'],
                'relationType' => $relationData['relation_type'],
            ];
        }
        return $relations;
    }

    protected function getKeeperId(array $relations): string
    {
        foreach ($relations as $relation) {
            if ($relation['relationType'] === 'keeper') {
                return $relation['relationId'];
            }
        }
        throw new AuthorizationFailedException("Unable to find keeper");
    }

    protected function getMemberIds(array $relations): array
    {
        $memberIds = [];
        foreach ($relations as $relation) {
            if ($relation['relationType'] === 'member') {
                $memberIds[] = $relation['collaboratorId'];
            }
        }
        return $memberIds;
    }
}
