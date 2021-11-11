<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Models\Workspace;

final class WorkspaceProvider extends BaseConcreteObjectProvider
{
    use EloquentProviderTrait, RelationTrait;

    protected function getAttributes(): array
    {
        $workspace = $this->getEloquentModel(Workspace::query(), $this->objectId);
        $relations = $this->getRelations($this->objectId);
        return [
            'objectId' => $this->objectId,
            'workspaceId' => $workspace->id,
            'keeperId' => $workspace->keeper_id,
            'memberIds' => $this->getMemberIds($relations),
            'profile' => $workspace->profile,
        ];
    }
}
