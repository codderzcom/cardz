<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Requirement;

use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirement;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementRemoved;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

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
