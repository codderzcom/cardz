<?php

namespace Cardz\Core\Workspaces\Infrastructure\ReadStorage\Contracts;

use Cardz\Core\Workspaces\Domain\ReadModel\ReadWorkspace;

interface ReadWorkspaceStorageInterface
{
    public function take(?string $workspaceId): ?ReadWorkspace;
}
