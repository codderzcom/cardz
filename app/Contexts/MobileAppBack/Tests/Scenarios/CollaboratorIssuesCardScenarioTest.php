<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class CollaboratorIssuesCardScenarioTest extends BaseScenarioTestCase
{
    public function test_collaborator_can_issue_cards()
    {
        $this->persistEnvironment();
        $collaborator = $this->environment->collaboratorInfos[0];
        $token = $this->getToken($collaborator);

        $customerInfo = $this->environment->customerInfos[0];

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES, $token)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, $token, ['workspaceId' => $workspaceId])->json();
        $planId = $plans[0]['planId'];

        $card = $this->routePost(RouteName::ISSUE_CARD, $token,
            ['workspaceId' => $workspaceId],
            ['planId' => $planId, 'customerId' => $customerInfo->id]
        )->json();

        $this->assertNotEmpty($card);
        $this->assertEquals($card['customerId'], $customerInfo->id);
        $this->assertEquals($card['planId'], $planId);
    }

    public function test_non_collaborator_cannot_issue_cards()
    {
        $this->persistEnvironment();
        $collaborator = end($this->environment->collaboratorInfos);
        $token = $this->getToken($collaborator);

        $workspaceId = $this->environment->workspaces[0]->workspaceId;
        $planId = $this->environment->plans[0]->planId;

        $response = $this->routeGet(RouteName::GET_PLANS, $token, ['workspaceId' => $workspaceId]);
        $response->assertForbidden();

        $response = $this->routePost(RouteName::ISSUE_CARD, $token,
            ['workspaceId' => $workspaceId],
            ['planId' => $planId, 'customerId' => $this->environment->customerInfos[0]->id]
        );
        $response->assertForbidden();
    }

}
