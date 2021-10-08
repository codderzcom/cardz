<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JsonSerializable;

final class ReadRequirement implements JsonSerializable
{
    use ArrayPresenterTrait;

    public function __construct(
        public string $requirementId,
        public string $planId,
        public string $description,
    ) {
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
