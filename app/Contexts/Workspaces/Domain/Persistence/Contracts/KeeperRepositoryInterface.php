<?php

namespace App\Contexts\Workspaces\Domain\Persistence\Contracts;

use App\Contexts\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;

interface KeeperRepositoryInterface
{
    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function take(KeeperId $keeperId): Keeper;
}
