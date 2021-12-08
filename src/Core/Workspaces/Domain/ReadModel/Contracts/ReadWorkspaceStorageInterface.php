<?php

namespace Cardz\Core\Workspaces\Domain\ReadModel\Contracts;

use Cardz\Core\Workspaces\Domain\ReadModel\ReadWorkspace;

interface ReadWorkspaceStorageInterface
{
    public function take(?string $workspaceId): ?ReadWorkspace;
}
