<?php

namespace Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class BusinessPlan
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $planId,
        public string $workspaceId,
        public string $description,
        public bool $isLaunched,
        public bool $isStopped,
        public bool $isArchived,
        public array $requirements,
    ) {
    }

    #[Pure]
    public static function make(
        string $planId,
        string $workspaceId,
        string $description,
        bool $isLaunched,
        bool $isStopped,
        bool $isArchived,
        array $requirements,
    ): self {
        return new self($planId, $workspaceId, $description, $isLaunched, $isStopped, $isArchived, $requirements);
    }

}
