<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Cardz\Core\Plans\Application\Commands\Plan\ArchivePlan;
use Cardz\Core\Plans\Domain\Events\Plan\PlanArchived;
use Cardz\Core\Plans\Infrastructure\Exceptions\PlanNotFoundException;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

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
