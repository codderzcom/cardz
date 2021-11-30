<?php

namespace Cardz\Support\Collaboration\Domain\Persistence\Contracts;

use Cardz\Support\Collaboration\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Cardz\Support\Collaboration\Domain\Model\Workspace\Keeper;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface KeeperRepositoryInterface
{
    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): Keeper;
}
