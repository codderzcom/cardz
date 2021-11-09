<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessPlan;

interface BusinessPlanReadStorageInterface
{
    public function find(string $planId): BusinessPlan;

    /**
     * @return BusinessPlan[]
     */
    public function allForWorkspace(string $workspaceId): array;

}
