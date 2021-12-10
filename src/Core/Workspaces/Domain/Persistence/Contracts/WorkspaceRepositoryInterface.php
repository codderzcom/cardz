<?php

namespace Cardz\Core\Workspaces\Domain\Persistence\Contracts;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

interface WorkspaceRepositoryInterface
{
    /**
     * @return AggregateEventInterface[]
     */
    public function store(Workspace $workspace): array;

    public function restore(WorkspaceId $workspaceId): Workspace;
}
