<?php

namespace App\Contexts\Collaboration\Application\Commands\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

interface LeaveRelationCommandInterface extends CommandInterface
{
    public function getCollaboratorId(): CollaboratorId;

    public function getWorkspaceId(): WorkspaceId;
}
