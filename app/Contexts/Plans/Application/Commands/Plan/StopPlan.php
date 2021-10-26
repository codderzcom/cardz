<?php

namespace App\Contexts\Plans\Application\Commands\Plan;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;

final class StopPlan implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
    ) {
    }

    public static function of(string $planId): self
    {
        return new self($planId);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }
}
