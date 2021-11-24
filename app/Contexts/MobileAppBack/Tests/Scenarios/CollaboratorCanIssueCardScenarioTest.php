<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Tests\Shared\Builders\EnvironmentBuilder;

class CollaboratorCanIssueCardScenarioTest extends BaseScenarioTestCase
{
    public function test_collaborator_can_issue_cards()
    {
        $collaborator = $this->environment->collaboratorInfos[0];
        $deviceName = $this->faker->word();
        $token = $this->post($this->getRoute('MABCustomerGetToken'), [
            'identity' => $collaborator->identity,
            'password' => $collaborator->password,
            'deviceName' => $deviceName,
        ])->json();

        $customerInfo = $this->environment->customerInfos[0];

        $workspaces = $this
            ->withHeader('Authorization', "Bearer: $token")
            ->get($this->getRoute('MABWorkspaceListAll'))
            ->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $plans = $this
            ->withHeader('Authorization', "Bearer: $token")
            ->get($this->getRoute('MABPlanListAll', ['workspaceId' => $workspaceId]))
            ->json();

        $planId = $plans[0]['planId'];

        $card = $this
            ->withHeader('Authorization', "Bearer: $token")
            ->post($this->getRoute('MABCardIssue', ['workspaceId' => $workspaceId]), ['planId' => $planId, 'customerId' => $customerInfo->id])
            ->json();

        $this->assertNotEmpty($card);
    }

}
