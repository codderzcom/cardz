<?php

namespace App\Contexts\Personal\Domain\Model\Person;

use App\Contexts\Personal\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Pure;

final class Name extends ValueObject
{
    private function __construct(private string $name)
    {
    }

    #[Pure]
    public static function of(string $name): self
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
