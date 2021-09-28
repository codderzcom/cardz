<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence\Contracts;

use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;

interface KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): ?Keeper;
}
