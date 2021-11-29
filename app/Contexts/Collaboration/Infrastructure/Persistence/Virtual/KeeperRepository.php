<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Virtual;

use App\Contexts\Collaboration\Domain\Model\Workspace\Keeper;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): Keeper
    {
        // ToDo: возможно следует получать из другого контекста
        return Keeper::restore((string) $keeperId, (string) $workspaceId);
    }
}
