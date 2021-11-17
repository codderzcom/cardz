<?php

namespace App\Contexts\Plans\Tests\Support\Mocks;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;

class PlanInMemoryRepository implements PlanRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Plan $plan): void
    {
        static::$storage[(string) $plan->planId] = $plan;
    }

    public function take(PlanId $planId): Plan
    {
        return static::$storage[(string) $planId];
    }
}
