<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\Description;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;

final class ChangePlanDescription implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
        private string $description,
    ) {
    }

    public static function of(string $planId, string $description): self
    {
        return new self($planId, $description);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    public function getDescription(): Description
    {
        return Description::of($this->description);
    }

}
