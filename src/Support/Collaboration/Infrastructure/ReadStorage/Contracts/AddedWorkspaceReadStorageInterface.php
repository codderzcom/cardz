<?php

namespace Cardz\Support\Collaboration\Infrastructure\ReadStorage\Contracts;

use Cardz\Support\Collaboration\Domain\ReadModel\AddedWorkspace;

interface AddedWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?AddedWorkspace;
}
