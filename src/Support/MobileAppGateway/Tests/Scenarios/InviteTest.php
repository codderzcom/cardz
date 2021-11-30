<?php

namespace Cardz\Support\MobileAppGateway\Tests\Scenarios;

use Cardz\Support\MobileAppGateway\Tests\Shared\Fixtures\RouteName;

class InviteTest extends BaseScenarioTestCase
{
    public function test_invite_can_be_proposed_and_discarded_by_keeper()
    {
        $this->persistEnvironment();
        $keeper = $this->environment->keeperInfos[0];
        $this->setAuthTokenFor($keeper);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $routeArgs = ['workspaceId' => $workspaceId];

        $response = $this->routePost(RouteName::PROPOSE_INVITE, $routeArgs);
        $response->assertSuccessful();
        $inviteId = $response->json();
        $this->assertNotEmpty($inviteId);

        $routeArgs = ['workspaceId' => $workspaceId, 'inviteId' => $inviteId];
        $response = $this->routeDelete(RouteName::DISCARD_INVITE, $routeArgs);
        $response->assertSuccessful();
    }

    public function test_invite_can_be_accepted()
    {
        $this->persistEnvironment();
        $intendedCollaborator = $this->environment->customerInfos[0];
        $this->setAuthTokenFor($intendedCollaborator);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $this->assertEmpty($workspaces);

        $invite = $this->environment->invites[0];

        $routeArgs = ['workspaceId' => $invite->workspaceId, 'inviteId' => $invite->inviteId];

        $response = $this->routePut(RouteName::ACCEPT_INVITE, $routeArgs);
        $response->assertSuccessful();

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $this->assertNotEmpty($workspaces);
        $this->assertEquals($invite->workspaceId, $workspaces[0]['workspaceId']);
    }


    public function test_invite_cannot_be_proposed_by_non_keeper()
    {
        $this->persistEnvironment();
        $collaborator = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaborator);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $routeArgs = ['workspaceId' => $workspaceId];

        $response = $this->routePost(RouteName::PROPOSE_INVITE, $routeArgs);
        $response->assertForbidden();
    }
}
