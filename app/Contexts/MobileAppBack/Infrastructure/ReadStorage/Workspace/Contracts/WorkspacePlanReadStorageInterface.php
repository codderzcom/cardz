<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\WorkspacePlan;

interface WorkspacePlanReadStorageInterface
{
    public function find(string $planId): ?WorkspacePlan;

    /**
     * @return WorkspacePlan[]
     */
    public function allForWorkspace(string $workspaceId): array;

}
