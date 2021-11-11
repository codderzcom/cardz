<?php

namespace App\Contexts\Plans\Domain\Persistence\Contracts;

use App\Contexts\Plans\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use App\Contexts\Plans\Domain\Model\Plan\Workspace;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function take(WorkspaceId $workspaceId): Workspace;
}
