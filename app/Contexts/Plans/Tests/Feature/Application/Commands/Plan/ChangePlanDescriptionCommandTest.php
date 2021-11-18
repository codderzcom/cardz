<?php

namespace App\Contexts\Plans\Tests\Feature\Application\Commands\Plan;

use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescription;
use App\Contexts\Plans\Domain\Events\Plan\PlanDescriptionChanged;
use App\Contexts\Plans\Tests\Feature\PlansTestHelperTrait;
use App\Contexts\Plans\Tests\Support\Builders\PlanBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

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
