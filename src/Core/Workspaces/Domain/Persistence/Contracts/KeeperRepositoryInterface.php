<?php

namespace Cardz\Core\Workspaces\Domain\Persistence\Contracts;

use Cardz\Core\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;

interface KeeperRepositoryInterface
{
    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function take(KeeperId $keeperId): Keeper;
}
