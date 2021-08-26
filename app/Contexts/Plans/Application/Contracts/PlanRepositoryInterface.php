<?php

namespace App\Contexts\Plans\Application\Contracts;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    public function take(PlanId $planId): ?Plan;
    public function save(Plan $plan): void;
}
