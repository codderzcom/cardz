<?php

namespace Cardz\Core\Workspaces\Tests\Support\Mocks;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;

class WorkspaceInMemoryRepository implements WorkspaceRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Workspace $workspace): void
    {
        static::$storage[(string) $workspace->workspaceId] = $workspace;
    }

    public function take(WorkspaceId $workspaceId): Workspace
    {
        return static::$storage[(string) $workspaceId];
    }
}
