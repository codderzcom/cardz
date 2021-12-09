<?php

namespace Cardz\Core\Workspaces\Domain\ReadModel\Contracts;

use Cardz\Core\Workspaces\Domain\ReadModel\AddedWorkspace;

interface AddedWorkspaceStorageInterface
{
    public function persist(AddedWorkspace $addedWorkspace): void;

    public function take(?string $workspaceId): ?AddedWorkspace;
}
