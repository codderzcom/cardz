<?php

namespace App\Contexts\Collaboration\Application\Contracts;

use App\Contexts\Collaboration\Domain\ReadModel\AddedWorkspace;

interface AddedWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?AddedWorkspace;
}
