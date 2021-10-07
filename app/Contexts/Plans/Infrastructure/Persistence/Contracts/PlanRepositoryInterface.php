<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Contracts;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    public function persist(Plan $plan): void;

    public function take(PlanId $planId): ?Plan;
}
