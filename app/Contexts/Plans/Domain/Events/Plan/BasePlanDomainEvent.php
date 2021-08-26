<?php

namespace App\Contexts\Plans\Domain\Events\Plan;

use App\Contexts\Plans\Domain\Events\BaseDomainEvent;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

abstract class BasePlanDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public PlanId $planId
    ) {
        parent::__construct();
    }
}
