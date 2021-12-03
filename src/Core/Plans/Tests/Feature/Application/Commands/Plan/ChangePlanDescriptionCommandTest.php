<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Cardz\Core\Plans\Application\Commands\Plan\ChangePlanDescription;
use Cardz\Core\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class ChangePlanDescriptionCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_description_can_be_changed()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);

        $command = ChangePlanDescription::of($plan->planId, 'Changed');
        $this->commandBus()->dispatch($command);

        $plan = $this->getPlanRepository()->take($command->getPlanId());
        $this->assertEquals('Changed', $plan->getDescription());

        $this->assertEvent(PlanDescriptionChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
