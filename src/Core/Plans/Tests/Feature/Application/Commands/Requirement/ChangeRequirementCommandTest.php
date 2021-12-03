<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Requirement;

use Cardz\Core\Plans\Application\Commands\Requirement\ChangeRequirement;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementChanged;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\RequirementBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

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
