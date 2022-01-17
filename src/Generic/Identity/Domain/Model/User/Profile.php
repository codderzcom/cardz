<?php

namespace Cardz\Generic\Identity\Domain\Model\User;

use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class Profile implements ValueObjectInterface
{
    private function __construct(
        private string $name,
    ) {
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

    #[ArrayShape(['name' => "string"])]
    public function toArray(): array
    {
        return ['name' => $this->name];
    }

}
