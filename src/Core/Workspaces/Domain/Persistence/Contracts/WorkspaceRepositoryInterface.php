<?php

namespace Cardz\Core\Workspaces\Domain\Persistence\Contracts;

use Cardz\Core\Workspaces\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    public function persist(Workspace $workspace): void;

    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function take(WorkspaceId $workspaceId): Workspace;
}
