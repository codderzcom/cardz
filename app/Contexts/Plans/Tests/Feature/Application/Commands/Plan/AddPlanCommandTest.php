<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Plan;

use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Contexts\Plans\Domain\Events\Plan\PlanAdded;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class AddPlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_added()
    {
        $planTemplate = PlanBuilder::make()->build();

        $command = AddPlan::of(PlanId::makeValue(), $planTemplate->getDescription());
        $this->commandBus()->dispatch($command);

        $plan = $this->getPlanRepository()->take($command->getPlanId());

        $this->assertEquals($command->getPlanId(), $plan->planId);
        $this->assertEvent(PlanAdded::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
