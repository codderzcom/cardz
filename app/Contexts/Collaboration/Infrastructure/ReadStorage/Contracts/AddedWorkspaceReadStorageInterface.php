<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Collaboration\Domain\ReadModel\AddedWorkspace;

interface AddedWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?AddedWorkspace;
}
