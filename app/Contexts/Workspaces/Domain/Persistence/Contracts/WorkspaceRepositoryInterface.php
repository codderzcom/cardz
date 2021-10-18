<?php

namespace App\Contexts\Workspaces\Domain\Persistence\Contracts;

use App\Contexts\Workspaces\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\Workspace;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    public function persist(Workspace $workspace): void;

    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function take(WorkspaceId $workspaceId): Workspace;
}
