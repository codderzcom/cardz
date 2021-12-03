<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Relation;

use Cardz\Support\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationEstablished;
use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationType;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class KeepWorkspaceCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_can_establish_keeper_relation()
    {
        $command = KeepWorkspace::of(KeeperId::makeValue(), WorkspaceId::makeValue());
        $this->commandBus()->dispatch($command);

        $collaboratorId = CollaboratorId::of($command->getKeeperId());

        $relation = $this->getRelationRepository()->find($collaboratorId, $command->getWorkspaceId());

        $this->assertEquals($command->getRelationId(), $relation->relationId);
        $this->assertEquals(RelationType::KEEPER, $relation->relationType);
        $this->assertEvent(RelationEstablished::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
