<?php

namespace App\Contexts\Workspaces\Tests\Support\Mocks;

use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;

class KeeperInMemoryRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): Keeper
    {
        return Keeper::restore($keeperId);
    }

}
