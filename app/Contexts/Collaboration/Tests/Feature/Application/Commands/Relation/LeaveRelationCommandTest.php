<?php

namespace App\Contexts\Collaboration\Tests\Feature\Application\Commands\Relation;

use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInvite;
use App\Contexts\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use App\Contexts\Collaboration\Application\Commands\Relation\EstablishRelation;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelation;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationEstablished;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationLeft;
use App\Contexts\Collaboration\Domain\Exceptions\InvalidOperationException;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;
use App\Contexts\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use App\Contexts\Collaboration\Tests\Support\Builders\RelationBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class LeaveRelationCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_can_leave_member_relation()
    {
        $relation = RelationBuilder::make()->build();
        $this->getRelationRepository()->persist($relation);

        $command = LeaveRelation::of($relation->collaboratorId, $relation->workspaceId);
        $this->commandBus()->dispatch($command);

        $this->assertTrue($relation->isLeft());
        $this->assertEvent(RelationLeft::class);
        $this->expectException(RelationNotFoundException::class);

        $this->getRelationRepository()->find($relation->collaboratorId, $relation->workspaceId);
    }

    public function test_cannot_leave_keeper_relation()
    {
        $relation = RelationBuilder::make()->buildForKeeper();
        $this->getRelationRepository()->persist($relation);

        $this->expectException(InvalidOperationException::class);

        $command = LeaveRelation::of($relation->collaboratorId, $relation->workspaceId);
        $this->commandBus()->dispatch($command);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
