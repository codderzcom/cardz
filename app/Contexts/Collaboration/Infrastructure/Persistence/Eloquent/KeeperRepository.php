<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Keeper\Keeper;
use App\Contexts\Collaboration\Domain\Model\Keeper\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\KeeperNotFoundException;
use App\Models\Workspace as EloquentKeeper;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): Keeper
    {
        // ToDo: а надо вообще из репа брать?
        $keeper = EloquentKeeper::query()
            ->where('keeper_id', '=', (string) $keeperId)
            ->where('id', '=', (string) $workspaceId)
            ->first();
        return $keeper ? Keeper::restore($keeper->id, $keeper->workspace_id) : throw new KeeperNotFoundException((string) $keeperId);
    }
}
