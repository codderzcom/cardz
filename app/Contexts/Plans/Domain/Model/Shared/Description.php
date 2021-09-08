<?php

namespace App\Contexts\Plans\Domain\Model\Shared;

use App\Contexts\Cards\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Description extends ValueObject
{
    private function __construct(private string $description)
    {
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

    public function __toString(): string
    {
        return $this->description;
    }
}
