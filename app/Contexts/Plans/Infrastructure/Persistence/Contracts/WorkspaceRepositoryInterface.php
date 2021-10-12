<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Contracts;

use App\Contexts\Plans\Domain\Model\Plan\Workspace;
use App\Contexts\Plans\Domain\Model\Plan\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    public function take(WorkspaceId $workspaceId): Workspace;
}
