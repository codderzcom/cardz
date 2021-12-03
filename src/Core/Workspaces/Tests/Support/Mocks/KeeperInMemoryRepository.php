<?php

namespace Cardz\Core\Workspaces\Tests\Support\Mocks;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;

class KeeperInMemoryRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): Keeper
    {
        return Keeper::restore($keeperId);
    }

}
