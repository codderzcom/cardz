<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Relation;

use Cardz\Support\Collaboration\Application\Commands\Relation\EstablishRelation;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationEstablished;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationType;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Cardz\Support\Collaboration\Tests\Support\Builders\RelationBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

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
