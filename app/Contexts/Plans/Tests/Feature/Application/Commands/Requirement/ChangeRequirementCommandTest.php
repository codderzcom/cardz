<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Requirement;

use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirement;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementChanged;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class ChangeRequirementCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_requirement_can_be_changed()
    {
        $requirement = RequirementBuilder::make()->build();
        $this->getRequirementRepository()->persist($requirement);

        $command = ChangeRequirement::of($requirement->requirementId, 'Changed');
        $this->commandBus()->dispatch($command);
        $requirement = $this->getRequirementRepository()->take($command->getRequirementId());

        $this->assertEquals('Changed', $requirement->getDescription());
        $this->assertEvent(RequirementChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
