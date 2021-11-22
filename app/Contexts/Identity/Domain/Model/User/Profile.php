<?php

namespace App\Contexts\Identity\Domain\Model\User;

use App\Shared\Contracts\Domain\ValueObjectInterface;

final class Profile implements ValueObjectInterface
{
    private function __construct(
        private string $name,
    ) {
    }

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
