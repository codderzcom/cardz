<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Shared\Contracts\Domain\ValueObjectInterface;
use JetBrains\PhpStorm\Pure;

final class Achievement implements ValueObjectInterface
{
    private function __construct(
        private string $id,
        private string $description,
    ) {
    }

    #[Pure]
    public static function of(string $id, string $description): self
    {
        return new self($id, $description);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    #[Pure]
    public function equals(self $requirement): bool
    {
        return $this->id === $requirement->id;
    }

    public function toArray(): array
    {
        return [$this->id, $this->description];
    }
}

