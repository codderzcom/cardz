<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Carbon\Carbon;
use Cardz\Core\Plans\Application\Commands\Plan\LaunchPlan;
use Cardz\Core\Plans\Domain\Events\Plan\PlanArchived;
use Cardz\Core\Plans\Domain\Events\Plan\PlanLaunched;
use Cardz\Core\Plans\Infrastructure\Exceptions\PlanNotFoundException;
use Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;
use Illuminate\Support\Facades\Artisan;

final class LaunchPlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_launched()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);
        $this->assertFalse($plan->isLaunched());

        $command = LaunchPlan::of($plan->planId, (string) Carbon::now()->addDay());
        $this->commandBus()->dispatch($command);

        $plan = $this->getPlanRepository()->take($command->getPlanId());
        $this->assertTrue($plan->isLaunched());
        $this->assertFalse($plan->isStopped());

        $this->assertEvent(PlanLaunched::class);
    }

    public function test_plan_can_be_expired()
    {
        $plan = PlanBuilder::make()->withLaunched(
            new Carbon('2000-01-01 01:01:01'),
            new Carbon('2001-01-01 01:01:01'),
        )->build();
        $this->getPlanRepository()->persist($plan);
        $this->assertTrue($plan->isLaunched());

        $mock = $this->mock(ReadPlanStorageInterface::class)->makePartial();
        $mock->shouldReceive('getExpiredIds')
            ->once()
            ->andReturn([$plan->planId]);

        Artisan::call('plans:expire');

        $this->expectException(PlanNotFoundException::class);
        $this->getPlanRepository()->take($plan->planId);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
