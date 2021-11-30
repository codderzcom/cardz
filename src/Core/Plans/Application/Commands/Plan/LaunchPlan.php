<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\PlanId;

final class LaunchPlan implements PlanCommandInterface
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
