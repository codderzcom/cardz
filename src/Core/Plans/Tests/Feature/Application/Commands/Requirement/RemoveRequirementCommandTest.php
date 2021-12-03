<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Requirement;

use Cardz\Core\Plans\Application\Commands\Requirement\RemoveRequirement;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementRemoved;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\RequirementBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class RemoveRequirementCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_requirement_can_be_removed()
    {
        $requirement = RequirementBuilder::make()->build();
        $this->getRequirementRepository()->persist($requirement);

        $command = RemoveRequirement::of($requirement->requirementId);
        $this->commandBus()->dispatch($command);
        $requirement = $this->getRequirementRepository()->take($command->getRequirementId());

        $this->assertEquals($command->getRequirementId(), $requirement->requirementId);
        $this->assertTrue($requirement->isRemoved());
        $this->assertEvent(RequirementRemoved::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
