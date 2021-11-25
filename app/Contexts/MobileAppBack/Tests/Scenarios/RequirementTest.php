<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

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

        $count = count($plan['requirements']);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];
        $plan = $this->routePost(RouteName::ADD_PLAN_REQUIREMENT, $routeArgs, ['description' => $this->faker->text()])->json();

        $this->assertCount($count+1, $plan['requirements']);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId, 'requirementId' => $plan['requirements'][0]['requirementId']];
        $changed = 'Changed';
        $plan = $this->routePut(RouteName::CHANGE_PLAN_REQUIREMENT, $routeArgs, ['description' => $changed]);

        $this->assertEquals($changed, $plan['requirements'][0]['description']);

        $plan = $this->routeDelete(RouteName::REMOVE_PLAN_REQUIREMENT, $routeArgs)->json();

        $this->assertCount($count, $plan['requirements']);
    }

}
