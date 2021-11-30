<?php

namespace Cardz\Core\Plans\Tests\Support\Mocks;

use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Exceptions\PlanNotFoundException;

class PlanInMemoryRepository implements PlanRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Plan $plan): void
    {
        static::$storage[(string) $plan->planId] = $plan;
    }

    public function take(PlanId $planId): Plan
    {
        /** @var Plan $plan */
        $plan = static::$storage[(string) $planId];
        if ($plan->isArchived()) {
            throw  new PlanNotFoundException();
        }
        return $plan;
    }
}
