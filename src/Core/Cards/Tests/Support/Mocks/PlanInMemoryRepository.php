<?php

namespace Cardz\Core\Cards\Tests\Support\Mocks;

use Cardz\Core\Cards\Domain\Model\Plan\Plan;
use Cardz\Core\Cards\Domain\Model\Plan\PlanId;
use Cardz\Core\Cards\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Cards\Tests\Support\Builders\PlanBuilder;

class PlanInMemoryRepository implements PlanRepositoryInterface
{
    public function take(PlanId $planId): Plan
    {
        return PlanBuilder::make()->withPlanId($planId)->build();
    }

}
