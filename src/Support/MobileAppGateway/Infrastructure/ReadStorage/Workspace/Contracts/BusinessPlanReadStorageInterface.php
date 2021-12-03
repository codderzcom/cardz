<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessPlan;

interface BusinessPlanReadStorageInterface
{
    public function find(string $planId): BusinessPlan;

    /**
     * @return BusinessPlan[]
     */
    public function allForWorkspace(string $workspaceId): array;

}
