<?php

namespace Cardz\Support\MobileAppGateway\Tests\Scenarios;

use Carbon\Carbon;
use Cardz\Core\Cards\Tests\Support\Builders\PlanBuilder;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Symfony\Component\HttpFoundation\Response;

class PlanTest extends BaseScenarioTestCase
{
    public function test_plan_can_be_added_by_keeper()
    {
        $this->persistEnvironment();
        $keeperInfo = $this->environment->keeperInfos[0];
        $this->setAuthTokenFor($keeperInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $planBuilder = PlanBuilder::make();

        $plan = $this->routePost(RouteName::ADD_PLAN,
            ['workspaceId' => $workspaceId],
            ['description' => $planBuilder->description]
        )->json();

        $this->assertEquals($workspaceId, $plan['workspaceId']);
    }

    public function test_plan_can_be_added_by_collaborator()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $planBuilder = PlanBuilder::make();

        $plan = $this->routePost(RouteName::ADD_PLAN,
            ['workspaceId' => $workspaceId],
            ['description' => $planBuilder->description]
        )->json();

        $this->assertEquals($workspaceId, $plan['workspaceId']);
    }

    public function test_plan_can_be_worked_on_by_collaborator()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $changed = 'Changed';

        $this->assertNotEquals($changed, $plan['description']);
        $this->assertFalse($plan['isLaunched']);
        $this->assertFalse($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];
        $routeParams = ['expirationDate' => (string) Carbon::now()->addDay()];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN, $routeArgs, $routeParams)->json();

        $this->assertNotEquals($changed, $plan['description']);
        $this->assertTrue($plan['isLaunched']);
        $this->assertFalse($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $plan = $this->routePut(RouteName::CHANGE_PLAN_DESCRIPTION, $routeArgs, ['description' => $changed])->json();

        $this->assertEquals($changed, $plan['description']);

        $plan = $this->routePut(RouteName::STOP_PLAN, $routeArgs)->json();

        $this->assertFalse($plan['isLaunched']);
        $this->assertTrue($plan['isStopped']);
        $this->assertFalse($plan['isArchived']);

        $plan = $this->routePut(RouteName::ARCHIVE_PLAN, $routeArgs)->json();
        $this->assertTrue($plan['isArchived']);
    }

    public function test_plan_cannot_be_accessed_by_stranger()
    {
        $this->persistEnvironment();
        $collaborator = end($this->environment->collaboratorInfos);
        $this->setAuthTokenFor($collaborator);

        $workspaceId = $this->environment->workspaces[0]->workspaceId;

        $response = $this->routePost(RouteName::ADD_PLAN, ['workspaceId' => $workspaceId], ['description' => 'description']);
        $response->assertForbidden();

        $planId = $this->environment->plans[0]->planId;

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];
        $routeParams = ['expirationDate' => (string) Carbon::now()->addDay()];

        $response = $this->routePut(RouteName::LAUNCH_PLAN, $routeArgs, $routeParams);
        $response->assertForbidden();

        $response = $this->routePut(RouteName::STOP_PLAN, $routeArgs);
        $response->assertForbidden();

        $response = $this->routePut(RouteName::ARCHIVE_PLAN, $routeArgs);
        $response->assertForbidden();
    }

    public function test_plan_can_be_relanunched()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];
        $routeParams = ['expirationDate' => (string) Carbon::now()->addDay()];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN,$routeArgs,$routeParams)->json();
        $this->assertTrue($plan['isLaunched']);

        $routeParams = ['expirationDate' => (string) Carbon::now()->addCentury()];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN,$routeArgs,$routeParams)->json();
        $this->assertTrue($plan['isLaunched']);
    }

    public function test_plan_canot_be_stopped_twice()
    {
        $this->persistEnvironment();
        $collaboratorInfo = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaboratorInfo);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $plan = $plans[0];
        $planId = $plan['planId'];

        $routeArgs = ['workspaceId' => $workspaceId, 'planId' => $planId];
        $routeParams = ['expirationDate' => (string) Carbon::now()->addDay()];

        $plan = $this->routePut(RouteName::LAUNCH_PLAN,$routeArgs,$routeParams)->json();
        $this->assertTrue($plan['isLaunched']);

        $plan = $this->routePut(RouteName::STOP_PLAN, $routeArgs)->json();
        $this->assertTrue($plan['isStopped']);

        $response = $this->routePut(RouteName::STOP_PLAN, $routeArgs);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

}
