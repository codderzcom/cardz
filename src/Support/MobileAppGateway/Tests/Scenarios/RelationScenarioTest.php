<?php

namespace Cardz\Support\MobileAppGateway\Tests\Scenarios;

use App\Models\Relation;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Cardz\Support\MobileAppGateway\Config\Routes\RouteName;
use Cardz\Support\MobileAppGateway\Domain\ReadModel\Collaboration\RelationType;

class RelationScenarioTest extends BaseScenarioTestCase
{
    public function test_relation_is_added_for_keeper()
    {
        $this->persistEnvironment();
        $keeper = $this->environment->keeperInfos[0];
        $this->setAuthTokenFor($keeper);

        $workspaceBuilder = WorkspaceBuilder::make();
        $workspace = $this->routePost(RouteName::ADD_WORKSPACE, [], [
            'name' => $workspaceBuilder->name,
            'description' => $workspaceBuilder->description,
            'address' => $workspaceBuilder->address,
        ])->json();

        $relation = Relation::query()
            ->where('collaborator_id', $keeper->id)
            ->where('workspace_id', $workspace['workspaceId'])
            ->where('relation_type', RelationType::KEEPER)
        ->first();

        $this->assertNotEmpty($relation);
    }

    public function test_relation_is_added_for_member()
    {
        $this->persistEnvironment();
        $intendedCollaborator = $this->environment->customerInfos[0];
        $this->setAuthTokenFor($intendedCollaborator);
        $invite = $this->environment->invites[0];

        $this->routePut(RouteName::ACCEPT_INVITE, ['workspaceId' => $invite->workspaceId, 'inviteId' => $invite->inviteId]);

        $relation = Relation::query()
            ->where('collaborator_id', $intendedCollaborator->id)
            ->where('workspace_id', $invite->workspaceId)
            ->where('relation_type', RelationType::MEMBER)
        ->first();

        $this->assertNotEmpty($relation);
    }

    public function test_keeper_cannot_leave_workspace()
    {
        $this->persistEnvironment();
        $keeper = $this->environment->keeperInfos[0];
        $this->setAuthTokenFor($keeper);

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $response = $this->routePost(RouteName::LEAVE_RELATION, ['workspaceId' => $workspaceId, 'collaboratorId' => $keeper->id]);
        $response->assertForbidden();
    }

    public function test_keeper_can_fire_collaborator()
    {
        $this->persistEnvironment();
        $keeper = $this->environment->keeperInfos[0];
        $this->setAuthTokenFor($keeper);
        $collaborator = $this->environment->collaboratorInfos[0];

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $response = $this->routePost(RouteName::FIRE_COLLABORATOR, ['workspaceId' => $workspaceId, 'collaboratorId' => $collaborator->id]);
        $response->assertSuccessful();
    }

    public function test_collaborator_cannot_fire_collaborator()
    {
        $this->persistEnvironment();
        $collaborator = $this->environment->collaboratorInfos[0];
        $this->setAuthTokenFor($collaborator);
        $secondCollaborator = $this->environment->collaboratorInfos[1];

        $workspaces = $this->routeGet(RouteName::GET_WORKSPACES)->json();
        $workspaceId = $workspaces[0]['workspaceId'];

        $response = $this->routePost(RouteName::FIRE_COLLABORATOR, ['workspaceId' => $workspaceId, 'collaboratorId' => $secondCollaborator->id]);
        $response->assertForbidden();
    }
}
