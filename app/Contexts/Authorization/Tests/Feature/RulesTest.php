<?php

namespace App\Contexts\Authorization\Tests\Feature;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class RulesTest extends BaseTestCase
{
    use AuthTestHelperTrait, ApplicationTestTrait;

    public function test_workspace_permissions()
    {
        $this->assertGranted(AuthorizationPermission::WORKSPACE_VIEW(), $this->keeperId, $this->workspaceId);
        $this->assertGranted(AuthorizationPermission::WORKSPACE_VIEW(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::WORKSPACE_VIEW(), $this->strangerId, $this->workspaceId);

        $this->assertGranted(AuthorizationPermission::WORKSPACE_CHANGE_PROFILE(), $this->keeperId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::WORKSPACE_CHANGE_PROFILE(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::WORKSPACE_CHANGE_PROFILE(), $this->strangerId, $this->workspaceId);

        $this->assertGranted(AuthorizationPermission::INVITE_PROPOSE(), $this->keeperId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::INVITE_PROPOSE(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::INVITE_PROPOSE(), $this->strangerId, $this->workspaceId);

        $this->assertGranted(AuthorizationPermission::INVITE_DISCARD(), $this->keeperId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::INVITE_DISCARD(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::INVITE_DISCARD(), $this->strangerId, $this->workspaceId);

        $this->assertDenied(AuthorizationPermission::COLLABORATION_LEAVE(), $this->keeperId, $this->workspaceId);
        $this->assertGranted(AuthorizationPermission::COLLABORATION_LEAVE(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::COLLABORATION_LEAVE(), $this->strangerId, $this->workspaceId);
    }

    public function test_plan_permissions()
    {
        $this->assertGranted(AuthorizationPermission::PLAN_ADD(), $this->keeperId, $this->workspaceId);
        $this->assertGranted(AuthorizationPermission::PLAN_ADD(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::PLAN_ADD(), $this->strangerId, $this->workspaceId);

        $this->assertGranted(AuthorizationPermission::PLAN_VIEW(), $this->keeperId, $this->workspaceId);
        $this->assertGranted(AuthorizationPermission::PLAN_VIEW(), $this->collaboratorId, $this->workspaceId);
        $this->assertDenied(AuthorizationPermission::PLAN_VIEW(), $this->strangerId, $this->workspaceId);

        $this->assertGranted(AuthorizationPermission::PLAN_CHANGE(), $this->keeperId, $this->planId);
        $this->assertGranted(AuthorizationPermission::PLAN_CHANGE(), $this->collaboratorId, $this->planId);
        $this->assertDenied(AuthorizationPermission::PLAN_CHANGE(), $this->strangerId, $this->planId);

        $this->assertGranted(AuthorizationPermission::PLAN_CARD_ADD(), $this->keeperId, $this->planId);
        $this->assertGranted(AuthorizationPermission::PLAN_CARD_ADD(), $this->collaboratorId, $this->planId);
        $this->assertDenied(AuthorizationPermission::PLAN_CARD_ADD(), $this->strangerId, $this->planId);
    }

    public function test_card_permissions()
    {
        $this->assertGranted(AuthorizationPermission::CARD_VIEW(), $this->keeperId, $this->cardId);
        $this->assertGranted(AuthorizationPermission::CARD_VIEW(), $this->collaboratorId, $this->cardId);
        $this->assertDenied(AuthorizationPermission::CARD_VIEW(), $this->strangerId, $this->cardId);

        $this->assertGranted(AuthorizationPermission::CARD_CHANGE(), $this->keeperId, $this->cardId);
        $this->assertGranted(AuthorizationPermission::CARD_CHANGE(), $this->collaboratorId, $this->cardId);
        $this->assertDenied(AuthorizationPermission::CARD_CHANGE(), $this->strangerId, $this->cardId);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupEnvironment();
    }

}
