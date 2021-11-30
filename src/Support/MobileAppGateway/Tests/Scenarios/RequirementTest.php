<?php

namespace Cardz\Support\MobileAppGateway\Tests\Scenarios;

use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;

class RequirementTest extends BaseScenarioTestCase
{
    public function test_requirement_can_be_worked_on_by_collaborator()
    {
        $this->persistEnvironment();

        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaboratorInfo);

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


    public function test_requirement_cannot_be_accessed_by_by_stranger()
    {
        $this->persistEnvironment();

        $collaborator = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaborator);

        $workspaceId = end($this->environment->workspaces)->workspaceId;
        $plan = end($this->environment->plans);
        $requirement = end($this->environment->requirements);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $plan->planId];
        $response = $this->routePost(RouteName::ADD_PLAN_REQUIREMENT, $routeArgs, ['description' => $this->faker->text()]);
        $response->assertForbidden();

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $plan->planId, 'requirementId' => $requirement->requirementId];
        $response = $this->routePut(RouteName::CHANGE_PLAN_REQUIREMENT, $routeArgs, ['description' => 'description']);
        $response->assertForbidden();
    }

}
