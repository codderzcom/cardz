<?php

namespace Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Models\User as EloquentKeeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Exceptions\KeeperNotFoundException;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): Keeper
    {
        $keeper = EloquentKeeper::query()->find((string) $keeperId);
        if ($keeper === null) {
            throw new KeeperNotFoundException((string) $keeperId);
        }
        return Keeper::restore($keeperId);
    }
}
