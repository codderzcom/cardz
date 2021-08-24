<?php

namespace App\Contexts\Cards\Infrasctructure\Persistence;

use App\Contexts\Cards\Domain\Model\Card\CardAggregateRoot;
use App\Contexts\Cards\Domain\Model\Card\CardId;

class CardRepository
{
    public function persist(CardAggregateRoot $card): void
    {

    }

    public function take(CardId $cardId): ?CardAggregateRoot
    {

    }
}
