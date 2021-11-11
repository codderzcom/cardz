<?php

namespace App\Contexts\Cards\Domain\ReadModel;

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
        public bool $isLaunched,
        public bool $isStopped,
        public array $requirements,
    ) {
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
