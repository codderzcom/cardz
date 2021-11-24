<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class PlanTest extends BaseScenarioTestCase
{
    public function test_plan_can_be_added()
    {
        $this->persistEnvironment();
        $keeperInfo = $this->environment->keeperInfos[0];
        $token = $this->getToken($keeperInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES, $token)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $planBuilder = PlanBuilder::make();

        $plan = $this->routePost(RouteName::ADD_PLAN,
            $token,
            ['workspaceId' => $workspaceId],
            ['description' => $planBuilder->description]
        )->json();

        $this->assertEquals($workspaceId, $plan['workspaceId']);
    }
}
