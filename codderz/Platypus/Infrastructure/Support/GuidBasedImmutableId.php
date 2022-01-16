<?php

namespace Codderz\Platypus\Infrastructure\Support;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Exceptions\ParameterAssertionException;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Guid\Guid;

#[Immutable]
class GuidBasedImmutableId implements GenericIdInterface
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

    #[Pure]
    public function equals(GenericIdInterface $id): bool
    {
        return $this->is((string) $id);
    }

    public function is(string $id): bool
    {
        return $this->id === $id;
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return [$this::shortName() => (string) $this];
    }
}
