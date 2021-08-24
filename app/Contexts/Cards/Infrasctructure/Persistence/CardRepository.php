<?php

namespace App\Contexts\Cards\Infrasctructure\Persistence;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use ReflectionClass;

class CardRepository
{
    public function persist(?Card $card = null): void
    {
        dd($card);
    }

    public function take(?CardId $cardId = null): ?Card
    {
        $reflection = new ReflectionClass(Card::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var ?Card $card */
        $card = $reflection->newInstanceWithoutConstructor();
        $creator?->invoke($card, $cardId ?? new CardId());
        return $card;
    }
}
