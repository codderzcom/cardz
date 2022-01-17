<?php

namespace Cardz\Generic\Identity\Domain\Model\User;

use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class Password implements ValueObjectInterface
{
    private function __construct(
        private string $passwordHash,
    ) {
    }

    public static function of(string $password): self
    {
        return new self(Hash::make($password));
    }

    #[Pure]
    public static function ofHash(string $passwordHash): self
    {
        return new self($passwordHash);
    }

    public function __toString(): string
    {
        return $this->passwordHash;
    }

    #[ArrayShape(['hash' => "string"])]
    public function toArray(): array
    {
        return [
            'hash' => $this->passwordHash,
        ];
    }
}
