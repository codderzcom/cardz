<?php

namespace App\Contexts\Cards\Infrastructure\Persistence\Contracts;

use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    public function take(PlanId $planId): ?Plan;
}
