<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Cardz\Core\Plans\Application\Commands\Plan\StopPlan;
use Cardz\Core\Plans\Domain\Events\Plan\PlanStopped;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class StopPlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_stopped()
    {
        $plan = PlanBuilder::make()->withLaunched()->build();
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
