<?php

namespace Cardz\Core\Plans\Tests\Support\Mocks;

use Cardz\Core\Plans\Domain\Model\Plan\Workspace;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use JetBrains\PhpStorm\Pure;

class WorkspaceInMemoryRepository implements WorkspaceRepositoryInterface
{
    #[Pure]
    public function take(WorkspaceId $workspaceId): Workspace
    {
        return Workspace::restore($workspaceId);
    }

}
