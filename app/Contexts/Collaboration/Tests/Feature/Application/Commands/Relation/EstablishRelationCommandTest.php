<?php

namespace App\Contexts\Collaboration\Tests\Feature\Application\Commands\Relation;

use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInvite;
use App\Contexts\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use App\Contexts\Collaboration\Application\Commands\Relation\EstablishRelation;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationEstablished;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use App\Contexts\Collaboration\Tests\Support\Builders\RelationBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class EstablishRelationCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_can_establish_member_relation()
    {
        $relationTemplate = RelationBuilder::make()->build();
        $command = EstablishRelation::of($relationTemplate->collaboratorId, $relationTemplate->workspaceId, $relationTemplate->relationType);
        $this->commandBus()->dispatch($command);

        $relation = $this->getRelationRepository()->find($command->getCollaboratorId(), $command->getWorkspaceId());

        $this->assertEquals($command->getRelationId(), $relation->relationId);
        $this->assertEquals(RelationType::MEMBER, $relation->relationType);
        $this->assertEvent(RelationEstablished::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
