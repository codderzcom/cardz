<?php

namespace App\Contexts\Collaboration\Application\Contracts;


use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Keeper;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface KeeperRepositoryInterface
{
    public function take(CollaboratorId $keeperId, WorkspaceId $workspaceId): ?Keeper;
}
