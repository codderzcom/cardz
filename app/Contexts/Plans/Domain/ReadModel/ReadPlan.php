<?php

namespace App\Contexts\Plans\Domain\ReadModel;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class ReadPlan
{
    use ArrayPresenterTrait;

    /** @param string[] $requirements */
    public function __construct(
        public string $planId,
        public string $workspaceId,
        public string $description,
        public array $requirements,
        public bool $isAdded,
        public bool $isLaunched,
        public bool $isStopped,
        public bool $isArchived,
    ) {
    }

    #[Pure]
    public static function of(Plan $plan): self
    {
        return new self(
            (string) $plan->planId,
            (string) $plan->workspaceId,
            (string) $plan->getDescription(),
            $plan->getRequirements()->toArray(),
            $plan->isAdded(),
            $plan->isLaunched(),
            $plan->isStopped(),
            $plan->isArchived(),
        );
    }
}
