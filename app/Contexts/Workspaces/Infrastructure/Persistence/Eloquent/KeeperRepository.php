<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Models\User as EloquentKeeper;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): ?Keeper
    {
        $keeper = EloquentKeeper::query()->find($keeperId);
        return $keeper ? new Keeper($keeperId) : null;
    }
}
