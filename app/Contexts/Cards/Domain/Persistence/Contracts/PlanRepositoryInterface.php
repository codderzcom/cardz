<?php

namespace App\Contexts\Cards\Domain\Persistence\Contracts;

use App\Contexts\Cards\Domain\Exceptions\PlanNotFoundExceptionInterface;
use App\Contexts\Cards\Domain\Model\Plan\Plan;
use App\Contexts\Cards\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function take(PlanId $planId): Plan;
}
