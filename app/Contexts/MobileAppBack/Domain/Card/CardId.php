<?php

namespace App\Contexts\MobileAppBack\Domain\Card;

use JetBrains\PhpStorm\Pure;

class CardId
{
    private function __construct(private string $id)
    {
    }

    #[Pure]
    public static function of(string $id): static
    {
        return new CardId($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
