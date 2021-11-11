<?php

namespace App\Contexts\Cards\Domain\Model\Plan;

use App\Shared\Contracts\Domain\ValueObjectInterface;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;

final class Requirement implements ValueObjectInterface
{
    use ArrayPresenterTrait;

    private function __construct(
        public string $requirementId,
        public string $description,
    ) {
    }

    public static function of(string $requirementId, string $description): self
    {
        return new self($requirementId, $description);
    }
}
