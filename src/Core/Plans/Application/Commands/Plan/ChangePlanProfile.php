<?php

namespace Cardz\Core\Plans\Application\Commands\Plan;

use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Model\Plan\Profile;
use JetBrains\PhpStorm\Pure;

final class ChangePlanProfile implements PlanCommandInterface
{
    private function __construct(
        private string $planId,
        private string $name,
        private string $description,
    ) {
    }

    #[Pure]
    public static function of(string $planId, string $name, string $description): self
    {
        return new self($planId, $name, $description);
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    #[Pure]
    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description);
    }

}
