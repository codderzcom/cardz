<?php

namespace App\Contexts\Plans\Domain\Persistence\Contracts;

use App\Contexts\Plans\Domain\Exceptions\PlanNotFoundExceptionInterface;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    public function persist(Plan $plan): void;

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function take(PlanId $planId): Plan;
}
