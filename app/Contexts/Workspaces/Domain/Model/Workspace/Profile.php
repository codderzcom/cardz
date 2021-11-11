<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use App\Shared\Contracts\Domain\ValueObjectInterface;
use App\Shared\Infrastructure\Support\ArrayPresenterTrait;
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
        private string $address,
    ) {
    }

    #[Pure]
    public static function create(string $name, string $description, string $address): self
    {
        return new self($name, $description, $address);
    }

    #[Pure]
    public static function ofData(array $profile): self
    {
        return self::of(
            $profile['name'] ?? '',
            $profile['description'] ?? '',
            $profile['address'] ?? '',
        );
    }

    #[Pure]
    public static function of(string $name, string $description, string $address): self
    {
        return new self($name, $description, $address);
    }

}
