<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class PlanTest extends BaseScenarioTestCase
{
    public function test_plan_can_be_added_by_keeper()
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

    public function test_plan_can_be_added_by_collaborator()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $token = $this->getToken($collaboratorInfo);

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

    public function test_plan_can_be_worked_on_by_collaborator()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $token = $this->getToken($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES, $token)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, $token, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $changed = 'Changed';

        $this->assertNotEquals($changed, $plan['description']);
        $this->assertFalse($plan['isLaunched']);
        $this->assertFalse($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN, $token, $routeArgs)->json();

        $this->assertNotEquals($changed, $plan['description']);
        $this->assertTrue($plan['isLaunched']);
        $this->assertFalse($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $plan = $this->routePut(RouteName::CHANGE_PLAN_DESCRIPTION, $token, $routeArgs, ['description' => $changed])->json();

        $this->assertEquals($changed, $plan['description']);

        $plan = $this->routePut(RouteName::STOP_PLAN, $token, $routeArgs)->json();

        $this->assertFalse($plan['isLaunched']);
        $this->assertTrue($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $plan = $this->routePut(RouteName::ARCHIVE_PLAN, $token, $routeArgs)->json();
        $this->assertTrue($plan['isArchived']);
    }

    public function test_plan_cannot_be_accessed_by_non_collaborator()
    {
        $this->persistEnvironment();
        $collaborator = end($this->environment->collaboratorInfos);
        $token = $this->getToken($collaborator);

        $workspaceId = $this->environment->workspaces[0]->workspaceId;
        $planId = $this->environment->plans[0]->planId;

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];

        $response = $this->routePut(RouteName::LAUNCH_PLAN, $token, $routeArgs);
        $response->assertForbidden();

        $response = $this->routePut(RouteName::STOP_PLAN, $token, $routeArgs);
        $response->assertForbidden();

        $response = $this->routePut(RouteName::ARCHIVE_PLAN, $token, $routeArgs);
        $response->assertForbidden();
    }

    public function test_plan_cannot_be_lanunched_or_stopped_twice()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $token = $this->getToken($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES, $token)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, $token, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN, $token, $routeArgs)->json();
        $this->assertTrue($plan['isLaunched']);

        $response = $this->routePut(RouteName::LAUNCH_PLAN, $token, $routeArgs);
        $response->assertStatus(500);

        $plan = $this->routePut(RouteName::STOP_PLAN, $token, $routeArgs)->json();
        $this->assertTrue($plan['isStopped']);

        $response = $this->routePut(RouteName::STOP_PLAN, $token, $routeArgs);
        $response->assertStatus(500);
    }

}
