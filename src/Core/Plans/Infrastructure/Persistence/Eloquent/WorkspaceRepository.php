<?php

namespace Cardz\Core\Plans\Infrastructure\Persistence\Eloquent;

use App\Models\Workspace as EloquentWorkspace;
use Cardz\Core\Plans\Domain\Model\Plan\Workspace;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Exceptions\WorkspaceNotFoundException;

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
