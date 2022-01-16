<?php

namespace Cardz\Support\Collaboration\Infrastructure\Persistence\Virtual;

use Cardz\Support\Collaboration\Domain\Model\Workspace\Keeper;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\KeeperRepositoryInterface;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function take(KeeperId $keeperId, WorkspaceId $workspaceId): Keeper
    {
        return Keeper::restore((string) $keeperId, (string) $workspaceId);
    }
}
