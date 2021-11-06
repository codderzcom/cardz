<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Models\Workspace;

final class WorkspaceProvider extends BaseConcreteObjectProvider
{
    use EloquentProviderTrait;

    protected function getAttributes(): array
    {
        $workspace = $this->getEloquentModel(Workspace::query(), $this->objectId);
        return [
            'workspaceId' => $workspace->id,
            'keeperId' => $workspace->keeper_id,
            'profile' => $workspace->profile,
        ];
    }
}
