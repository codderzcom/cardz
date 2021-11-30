<?php

namespace Cardz\Support\Collaboration\Domain\ReadModel;

use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;

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
