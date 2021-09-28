<?php

namespace App\Contexts\Workspaces\Infrastructure\Persistence;

use App\Contexts\Workspaces\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\Keeper;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Models\User as EloquentKeeper;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId): ?Keeper
    {
        $keeper = EloquentKeeper::query()->find($keeperId);
        return $keeper ? new Keeper($keeperId) : null;
    }
}
