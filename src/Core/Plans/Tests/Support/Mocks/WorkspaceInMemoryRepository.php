<?php

namespace Cardz\Core\Plans\Tests\Support\Mocks;

use Cardz\Core\Plans\Domain\Model\Plan\Workspace;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;

class WorkspaceInMemoryRepository implements WorkspaceRepositoryInterface
{
    public function take(WorkspaceId $workspaceId): Workspace
    {
        return Workspace::restore($workspaceId);
    }

}
