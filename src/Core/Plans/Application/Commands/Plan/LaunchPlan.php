<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Carbon\Carbon;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;

final class LaunchPlan implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
        private string $expirationDate,
    ) {
    }

    public static function of(string $planId, string $expirationDate): self
    {
        return new self($planId, $expirationDate);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    public function getExpirationDate(): Carbon
    {
        return new Carbon($this->expirationDate);
    }
}
