<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessPlan;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessPlanNotFoundException;

interface BusinessPlanReadStorageInterface
{
    /**
     * @throws BusinessPlanNotFoundException
     */
    public function find(string $planId): BusinessPlan;

    /**
     * @return BusinessPlan[]
     */
    public function allForWorkspace(string $workspaceId): array;

}
