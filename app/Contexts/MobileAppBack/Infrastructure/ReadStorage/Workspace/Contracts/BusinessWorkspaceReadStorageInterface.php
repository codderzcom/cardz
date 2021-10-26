<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;

interface BusinessWorkspaceReadStorageInterface
{
    public function find(string $workspaceId): ?BusinessWorkspace;

    /**
     * @return BusinessWorkspace[]
     */
    public function allForKeeper(string $keeperId): array;

}
