<?php

namespace App\Contexts\Plans\Domain\ReadModel;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

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
}
