<?php

namespace Cardz\Core\Plans\Domain\Persistence\Contracts;

use Cardz\Core\Plans\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Cardz\Core\Plans\Domain\Model\Plan\Workspace;
use Cardz\Core\Plans\Domain\Model\Plan\WorkspaceId;

interface WorkspaceRepositoryInterface
{
    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function take(WorkspaceId $workspaceId): Workspace;
}
