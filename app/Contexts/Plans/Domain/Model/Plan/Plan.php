<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

class Plan
{
    public function __construct(
        public PlanId $planId
    )
    {
    }
}
