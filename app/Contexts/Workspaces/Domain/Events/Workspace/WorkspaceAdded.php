<?php

namespace App\Contexts\Workspaces\Domain\Events\Workspace;

use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class WorkspaceAdded extends BaseWorkspaceDomainEvent
{
    public static function with(WorkspaceId $workspaceId): static
    {
        return new static($workspaceId);
    }
}
