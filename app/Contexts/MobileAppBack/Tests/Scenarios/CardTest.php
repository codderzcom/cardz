<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;

class CardTest extends BaseScenarioTestCase
{
    public function test_collaborator_can_issue_cards()
    {
        $this->persistEnvironment();
        $collaborator = $this->environment->collaboratorInfos[0];
        $this->token = $this->getToken($collaborator);

        $customerInfo = $this->environment->customerInfos[0];

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $planId = $plans[0]['planId'];

        $card = $this->routePost(RouteName::ISSUE_CARD,
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
        $this->token = $this->getToken($collaborator);

        $workspaceId = $this->environment->workspaces[0]->workspaceId;
        $planId = $this->environment->plans[0]->planId;

        $response = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId]);
        $response->assertForbidden();

        $response = $this->routePost(RouteName::ISSUE_CARD,
            ['workspaceId' => $workspaceId],
            ['planId' => $planId, 'customerId' => $this->environment->customerInfos[0]->id]
        );
        $response->assertForbidden();
    }

    public function test_card_is_satisfied_on_completion()
    {
        $this->persistEnvironment();
        $collaborator = end($this->environment->collaboratorInfos);
        $this->token = $this->getToken($collaborator);
        $customerInfo = $this->environment->customerInfos[0];

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this->routeGet(RouteName::GET_PLANS, ['workspaceId' => $workspaceId])->json();
        $planId = $plans[1]['planId'];

        $card = $this->routePost(RouteName::ISSUE_CARD,
            ['workspaceId' => $workspaceId],
            ['planId' => $planId, 'customerId' => $customerInfo->id]
        )->json();

        $routeArgs = ['workspaceId' => $workspaceId, 'cardId' => $card['cardId']];

        foreach ($card['requirements'] as $requirement) {
            $this->routePost(RouteName::NOTE_ACHIEVEMENT, $routeArgs, [
                'achievementId' => $requirement['requirementId'],
                'description' => $requirement['description'],
            ]);
        }

        $card = $this->routeGet(RouteName::GET_CARD, $routeArgs)->json();
        $this->assertTrue($card['isSatisfied']);

        $response = $this->routePut(RouteName::BLOCK_CARD, $routeArgs);
        $response->assertSuccessful();

        $response = $this->routePut(RouteName::UNBLOCK_CARD, $routeArgs);
        $response->assertSuccessful();

        $this->routePut(RouteName::COMPLETE_CARD, $routeArgs);

        $card = $this->routeGet(RouteName::GET_CARD, $routeArgs)->json();
        $this->assertTrue($card['isCompleted']);

        $response = $this->routePut(RouteName::BLOCK_CARD, $routeArgs);
        $response->assertStatus(500);
    }

}
