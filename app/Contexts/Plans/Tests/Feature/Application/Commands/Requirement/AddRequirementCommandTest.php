<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Requirement;

use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Contexts\Plans\Application\Commands\Requirement\AddRequirement;
use App\Contexts\Plans\Domain\Events\Plan\PlanAdded;
use App\Contexts\Plans\Domain\Events\Requirement\RequirementAdded;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Contexts\Plans\Tests\Support\Builders\RequirementBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

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
