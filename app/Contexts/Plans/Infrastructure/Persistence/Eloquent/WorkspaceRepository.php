<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Eloquent;

use App\Contexts\Plans\Domain\Model\Plan\Workspace;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;
use App\Contexts\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Exceptions\WorkspaceNotFoundException;
use App\Models\Workspace as EloquentWorkspace;

class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    public function take(WorkspaceId $workspaceId): Workspace
    {
        $workspace = EloquentWorkspace::query()->find((string) $workspaceId);
        if ($workspace === null) {
            throw new WorkspaceNotFoundException((string) $workspaceId);
        }
        return Workspace::restore($workspaceId);
    }
}
