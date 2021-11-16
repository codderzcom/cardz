<?php

namespace App\Contexts\MobileAppBack\Tests\Workspace\Scenario;

use App\Contexts\MobileAppBack\Tests\Shared\BaseScenarioTest;
use App\Contexts\MobileAppBack\Tests\Shared\Workspace\SetupScenarioEnvironmentTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KeeperIssueCardsToCustomerTest extends BaseScenarioTest
{
    use RefreshDatabase, SetupScenarioEnvironmentTrait;

    public function test_keeper_can_issue_personalized_cards()
    {
        $customerId = $this
            ->withHeader('Authorization', 'Bearer: ' . $this->firstCustomerToken)
            ->get(self::MAB_API . '/customer/id')
            ->json();

        $cardId = $this
            ->withHeader('Authorization', 'Bearer: ' . $this->firstKeeperToken)
            ->post(self::MAB_API . "/workspace/$this->firstWorkspaceId/card", [
                'customerId' => $customerId,
                'planId' => $this->firstPlanId,
                'description' => 'customer card',
            ])->json('cardId');

        $this->assertNotEmpty($cardId);

        $response = $this
            ->withHeader('Authorization', 'Bearer: ' . $this->firstCustomerToken)
            ->get(self::MAB_API . "/customer/card/$cardId");
        $response->assertSuccessful();

        $response = $this
            ->withHeader('Authorization', 'Bearer: ' . $this->secondCustomerToken)
            ->get(self::MAB_API . "/customer/card/$cardId");
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupEnvironment();
    }

}
