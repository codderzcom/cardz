<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Domain\Model\Collaboration\RelationType;
use App\Contexts\MobileAppBack\Tests\Shared\Fixtures\RouteName;
use App\Contexts\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use App\Models\Relation;

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
}
