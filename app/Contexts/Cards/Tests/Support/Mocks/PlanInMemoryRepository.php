<?php

namespace App\Contexts\Cards\Tests\Support\Mocks;

use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;
use App\Contexts\Cards\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Cards\Tests\Support\Builders\PlanBuilder;

class PlanInMemoryRepository implements PlanRepositoryInterface
{
    public function take(PlanId $planId): Plan
    {
        return PlanBuilder::make()->buildForId($planId);
    }

}
