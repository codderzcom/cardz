<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Stringable;

#[Immutable]
final class Description implements Stringable
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
