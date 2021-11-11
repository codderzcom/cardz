<?php

namespace App\Contexts\Plans\Domain\ReadModel;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JsonSerializable;

final class ReadPlan implements JsonSerializable
{
    use ArrayPresenterTrait;

    /** @param ReadRequirement[] $requirements */
    public function __construct(
        public string $planId,
        public string $workspaceId,
        public string $description,
        public bool $isAdded,
        public bool $isLaunched,
        public bool $isStopped,
        public bool $isArchived,
        public array $requirements,
    ) {
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
