<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Infrastructure\Exceptions\KeeperNotFoundException;
use App\Models\User as EloquentKeeper;

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
