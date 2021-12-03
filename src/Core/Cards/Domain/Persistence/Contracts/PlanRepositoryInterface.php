<?php

namespace Cardz\Core\Cards\Domain\Persistence\Contracts;

use Cardz\Core\Cards\Domain\Exceptions\PlanNotFoundExceptionInterface;
use Cardz\Core\Cards\Domain\Model\Plan\Plan;
use Cardz\Core\Cards\Domain\Model\Plan\PlanId;

interface PlanRepositoryInterface
{
    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function take(PlanId $planId): Plan;
}
