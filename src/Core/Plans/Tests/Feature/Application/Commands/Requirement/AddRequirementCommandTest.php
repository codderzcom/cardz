<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Requirement;

use Cardz\Core\Plans\Application\Commands\Requirement\AddRequirement;
use Cardz\Core\Plans\Domain\Events\Requirement\RequirementAdded;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Cardz\Core\Plans\Tests\Support\Builders\RequirementBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class AddRequirementCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_requirement_can_be_added()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);
        $requirementTemplate = RequirementBuilder::make()->build();

        $command = AddRequirement::of($plan->planId, $requirementTemplate->getDescription());
        $this->commandBus()->dispatch($command);
        $requirement = $this->getRequirementRepository()->take($command->getRequirementId());

        $this->assertEquals($command->getRequirementId(), $requirement->requirementId);
        $this->assertEvent(RequirementAdded::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
