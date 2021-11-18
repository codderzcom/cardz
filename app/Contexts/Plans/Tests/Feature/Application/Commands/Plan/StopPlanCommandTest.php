<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Plan;

use App\Contexts\Plans\Application\Commands\Plan\StopPlan;
use App\Contexts\Plans\Domain\Events\Plan\PlanStopped;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class StopPlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_stopped()
    {
        $plan = PlanBuilder::make()->buildLaunched();
        $this->getPlanRepository()->persist($plan);
        $this->assertFalse($plan->isStopped());

        $command = StopPlan::of($plan->planId);
        $this->commandBus()->dispatch($command);

        $plan = $this->getPlanRepository()->take($command->getPlanId());
        $this->assertTrue($plan->isStopped());
        $this->assertFalse($plan->isLaunched());

        $this->assertEvent(PlanStopped::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
