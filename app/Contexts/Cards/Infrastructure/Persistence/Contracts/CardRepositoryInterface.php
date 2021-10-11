<?php

namespace App\Contexts\Cards\Infrastructure\Persistence\Contracts;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;

interface CardRepositoryInterface
{
    public function persist(Card $card): void;

    public function take(CardId $cardId): ?Card;
}
