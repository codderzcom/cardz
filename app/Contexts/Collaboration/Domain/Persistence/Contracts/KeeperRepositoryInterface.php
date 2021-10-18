<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Keeper;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface KeeperRepositoryInterface
{
    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function take(CollaboratorId $keeperId, WorkspaceId $workspaceId): Keeper;
}
