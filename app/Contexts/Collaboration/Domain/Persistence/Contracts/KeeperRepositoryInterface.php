<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Keeper\Keeper;
use App\Contexts\Collaboration\Domain\Model\Keeper\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface KeeperRepositoryInterface
{
    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): Keeper;
}
