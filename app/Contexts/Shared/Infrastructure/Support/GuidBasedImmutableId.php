<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Exceptions\ParameterAssertionException;
use JetBrains\PhpStorm\Immutable;
use Ramsey\Uuid\Guid\Guid;
use Stringable;

#[Immutable]
class GuidBasedImmutableId implements Stringable
{
    protected function __construct(private string $id)
    {
    }

    public static function make(): static
    {
        return new static((string) Guid::uuid4());
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

    final public function equals(self $immutableId): bool
    {
        return $this->id === $immutableId->id;
    }
}
