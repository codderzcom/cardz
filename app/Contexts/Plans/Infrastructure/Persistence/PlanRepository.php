<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

class PlanRepository implements PlanRepositoryInterface
{
    public function take(PlanId $planId): ?Plan
    {
        // TODO: Implement take() method.
        return null;
    }

    public function save(Plan $plan): void
    {
        // TODO: Implement save() method.
    }

}
