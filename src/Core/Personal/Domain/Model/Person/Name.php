<?php

namespace Cardz\Core\Personal\Domain\Model\Person;

use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use JetBrains\PhpStorm\Pure;

final class Name implements ValueObjectInterface
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

    public function toArray(): array
    {
        return ['name' => $this->name];
    }
}
