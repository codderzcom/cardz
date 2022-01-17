<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use JetBrains\PhpStorm\Pure;

final class StopPlan implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
    ) {
    }

    #[Pure]
    public static function of(string $planId): self
    {
        return new self($planId);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }
}
