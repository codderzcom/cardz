<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Collaboration\Domain\ReadModel\AddedWorkspace;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;
use App\Models\Workspace as EloquentWorkspace;

class AddedWorkspaceReadStorage implements AddedWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?AddedWorkspace
    {
        $eloquentWorkspace = EloquentWorkspace::query()->find($workspaceId);
        if ($eloquentWorkspace === null) {
            return null;
        }
        return AddedWorkspace::restore($eloquentWorkspace->id, $eloquentWorkspace->keeper_id);
    }

}
