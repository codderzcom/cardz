<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class RequirementTest extends BaseScenarioTestCase
{
    public function test_requirement_can_be_worked_on_by_collaborator()
    {
        $this->persistEnvironment();

        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->token = $this->getToken($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $this->assertCount(0, $plan['requirements']);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];

        $plan = $this->routePost(RouteName::ADD_PLAN_REQUIREMENT, $routeArgs, ['description' => $this->faker->text()])->json();

        $this->assertCount(1, $plan['requirements']);

    }

}
