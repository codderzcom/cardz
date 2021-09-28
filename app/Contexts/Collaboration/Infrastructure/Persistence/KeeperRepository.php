<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence;

use App\Contexts\Collaboration\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Collaborator\Keeper;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Models\Workspace as EloquentKeeper;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(CollaboratorId $keeperId, WorkspaceId $workspaceId): ?Keeper
    {
        $keeper = EloquentKeeper::query()
            ->where('keeper_id', '=', (string) $keeperId)
            ->where('id', '=', (string) $workspaceId)
            ->first();
        return $keeper ? new Keeper($keeperId, $workspaceId) : null;
    }
}
