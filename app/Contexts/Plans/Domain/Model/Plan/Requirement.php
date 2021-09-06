<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Contexts\Plans\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Pure;

final class Requirement extends ValueObject
{
    private function __construct(
        private string $description,
    ) {
    }

    #[Pure]
    public static function of(string $description): self
    {
        return new self($description);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    #[Pure]
    public function equals(self $requirement): bool
    {
        return $requirement->getDescription() === $this->description;
    }

    private function from(
        string $description,
    ): void {
        $this->description = $description;
    }
}
