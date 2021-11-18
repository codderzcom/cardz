<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Plan;

use App\Contexts\Plans\Application\Commands\Plan\ArchivePlan;
use App\Contexts\Plans\Domain\Events\Plan\PlanArchived;
use App\Contexts\Plans\Infrastructure\Exceptions\PlanNotFoundException;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

final class ArchivePlanCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_can_be_archived()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);
        $this->assertFalse($plan->isArchived());

        $command = ArchivePlan::of($plan->planId);
        $this->commandBus()->dispatch($command);

        $this->assertEvent(PlanArchived::class);

        $this->expectException(PlanNotFoundException::class);
        $this->getPlanRepository()->take($command->getPlanId());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
