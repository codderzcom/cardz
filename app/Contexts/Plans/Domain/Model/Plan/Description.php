<?php

namespace App\Contexts\Plans\Domain\Model\Plan;

use App\Shared\Contracts\Domain\ValueObjectInterface;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Description implements ValueObjectInterface
{
    use ArrayPresenterTrait;

    private function __construct(private string $description)
    {
    }

    #[Pure]
    public static function of(string $description): self
    {
        return new self($description);
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
