<?php

namespace App\Shared\Infrastructure\Support;

use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Exceptions\ParameterAssertionException;
use JetBrains\PhpStorm\Immutable;
use Ramsey\Uuid\Guid\Guid;

#[Immutable]
class GuidBasedImmutableId implements GeneralIdInterface
{
    use ShortClassNameTrait;

    protected function __construct(private string $id)
    {
    }

    public static function make(): static
    {
        return new static((string) Guid::uuid4());
    }

    public static function makeValue(): string
    {
        return (string) Guid::uuid4();
    }

    public static function of(string $id): static
    {
        if (!Guid::isValid($id)) {
            throw new ParameterAssertionException("Valid Guid expected. $id received.");
        }
        return new static($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(GeneralIdInterface $id): bool
    {
        return $this->id === $id->id;
    }

    public function isA(string $id): bool
    {
        return $this->id === $id;
    }

    public function jsonSerialize()
    {
        return [$this::shortName() => (string) $this];
    }
}
