<?php

namespace App\Contexts\Collaboration\Domain\ReadModel;

use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class AddedWorkspace
{
    public function __construct(
        public WorkspaceId $workspaceId,
        public CollaboratorId $collaboratorId,
    ) {
    }
}
