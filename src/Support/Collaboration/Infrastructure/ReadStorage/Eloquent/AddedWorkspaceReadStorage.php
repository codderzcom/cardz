<?php

namespace Cardz\Support\Collaboration\Infrastructure\ReadStorage\Eloquent;

use App\Models\Workspace as EloquentWorkspace;
use Cardz\Support\Collaboration\Domain\ReadModel\AddedWorkspace;
use Cardz\Support\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;

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
