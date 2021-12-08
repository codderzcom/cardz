<?php

namespace Cardz\Core\Workspaces\Domain\Persistence\Contracts;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;

interface WorkspaceStoreInterface
{
    public function store(Workspace $workspace): array;

    public function restore(WorkspaceId $workspaceId): Workspace;
}
