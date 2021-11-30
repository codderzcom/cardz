<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Relation;

use Cardz\Support\Collaboration\Application\Commands\Relation\LeaveRelation;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationLeft;
use Cardz\Support\Collaboration\Domain\Exceptions\InvalidOperationException;
use Cardz\Support\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Cardz\Support\Collaboration\Tests\Support\Builders\RelationBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

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
