<?php

namespace App\Contexts\Plans\Domain\Events\Plan;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class PlanAdded extends BasePlanDomainEvent
{
    public static function with(PlanId $planId): self
    {
        return new self($planId);
    }
}
