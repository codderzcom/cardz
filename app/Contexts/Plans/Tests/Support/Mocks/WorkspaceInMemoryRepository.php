<?php

namespace App\Contexts\Plans\Tests\Support\Mocks;

use App\Contexts\Plans\Domain\Model\Plan\Workspace;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;
use App\Contexts\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;

class WorkspaceInMemoryRepository implements WorkspaceRepositoryInterface
{
    public function take(WorkspaceId $workspaceId): Workspace
    {
        return Workspace::restore($workspaceId);
    }

}
