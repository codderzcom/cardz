<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Contexts\Shared\Infrastructure\Support\ArrayPresenterTrait;

final class StatefulRequirement
{
    use ArrayPresenterTrait;

    private function __construct(
        private string $requirementId,
        private string $description,
        private bool $achieved,
    ) {
    }

    public static function make(string $requirementId, string $description, bool $achieved): self
    {
        return new self($requirementId, $description, $achieved);
    }
}
