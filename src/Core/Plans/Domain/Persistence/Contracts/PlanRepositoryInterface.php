<?php

namespace Cardz\Core\Plans\Domain\Persistence\Contracts;

use Cardz\Core\Plans\Domain\Exceptions\PlanNotFoundExceptionInterface;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    public function persist(Plan $plan): void;

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function take(PlanId $planId): Plan;
}
