<?php

namespace Cardz\Core\Plans\Domain\Model\Plan;

use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Profile implements ValueObjectInterface
{
    use ArrayPresenterTrait;

    #[Pure]
    private function __construct(
        private string $name,
        private string $description,
    ) {
    }

    #[Pure]
    public static function create(string $name, string $description): self
    {
        return new self($name, $description);
    }

    #[Pure]
    public static function ofData(array $profile): self
    {
        return self::of(
            $profile['name'] ?? '',
            $profile['description'] ?? '',
        );
    }

    #[Pure]
    public static function of(string $name, string $description): self
    {
        return new self($name, $description);
    }
}
