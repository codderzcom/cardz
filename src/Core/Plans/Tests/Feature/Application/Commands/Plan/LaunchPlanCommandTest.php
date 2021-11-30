<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Cardz\Core\Plans\Application\Commands\Plan\LaunchPlan;
use Cardz\Core\Plans\Domain\Events\Plan\PlanLaunched;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class LaunchPlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_launched()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);
        $this->assertFalse($plan->isLaunched());

        $command = LaunchPlan::of($plan->planId);
        $this->commandBus()->dispatch($command);

        $plan = $this->getPlanRepository()->take($command->getPlanId());
        $this->assertTrue($plan->isLaunched());
        $this->assertFalse($plan->isStopped());

        $this->assertEvent(PlanLaunched::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
