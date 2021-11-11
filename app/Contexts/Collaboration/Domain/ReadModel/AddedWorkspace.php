<?php

namespace App\Contexts\Collaboration\Domain\ReadModel;

use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AddedWorkspace
{
    private function __construct(
        public WorkspaceId $workspaceId,
        public KeeperId $keeperId,
    ) {
    }

    public static function restore(string $workspaceId, string $keeperId): self
    {
        return new self(WorkspaceId::of($workspaceId), KeeperId::of($keeperId));
    }
}
