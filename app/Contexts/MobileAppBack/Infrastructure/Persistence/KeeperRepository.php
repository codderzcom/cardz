<?php

namespace App\Contexts\MobileAppBack\Infrastructure\Persistence;

use App\Contexts\MobileAppBack\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\Keeper;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\RelationType;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Models\Relation as EloquentKeeper;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): ?Keeper
    {
        $keeper = EloquentKeeper::query()
            ->where('collaborator_id', '=', (string) $keeperId)
            ->where('workspace_id', '=', (string) $workspaceId)
            ->where('relation_type', '=', RelationType::KEEPER)
            ->first();
        return $keeper ? new Keeper($keeperId, $workspaceId) : null;
    }
}
