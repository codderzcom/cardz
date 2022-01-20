<?php

namespace Cardz\Core\Plans\Tests\Feature\Application\Commands\Plan;

use Cardz\Core\Plans\Application\Commands\Plan\ChangePlanProfile;
use Cardz\Core\Plans\Domain\Events\Plan\PlanProfileChanged;
use Cardz\Core\Plans\Domain\Model\Plan\Profile;
use Cardz\Core\Plans\Tests\Feature\PlansTestHelperTrait;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

final class ChangePlanProfileCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PlansTestHelperTrait;

    public function test_plan_profile_can_be_changed()
    {
        $plan = PlanBuilder::make()->build();
        $this->getPlanRepository()->persist($plan);

        $command = ChangePlanProfile::of($plan->planId, 'Changed', 'Changed');
        $this->commandBus()->dispatch($command);

        $profile = Profile::of('Changed', 'Changed');
        $plan = $this->getPlanRepository()->take($command->getPlanId());
        $this->assertEquals($profile->toArray(), $plan->getProfile()->toArray());

        $this->assertEvent(PlanProfileChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
