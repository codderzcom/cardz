<?php

namespace App\Contexts\Auth\Domain\Model\User;

use App\Contexts\Auth\Domain\Model\Shared\ValueObject;

final class Profile extends ValueObject
{
    private function __construct(
        private string $name,
    ) {
    }

    public static function of(string $name): self
    {
        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

}
