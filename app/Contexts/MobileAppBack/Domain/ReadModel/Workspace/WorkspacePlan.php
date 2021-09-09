<?php

namespace App\Contexts\MobileAppBack\Domain\ReadModel\Workspace;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Pure;

final class WorkspacePlan
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $planId,
        public string $workspaceId,
        public string $description,
        public array $requirements,
    ) {
    }

    #[Pure]
    public static function make(
        string $planId,
        string $workspaceId,
        string $description,
        array $requirements,
    ): self {
        return new self($planId, $workspaceId, $description, $requirements);
    }

}
