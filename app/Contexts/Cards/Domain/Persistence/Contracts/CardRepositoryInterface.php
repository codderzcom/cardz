<?php

namespace App\Contexts\Cards\Domain\Persistence\Contracts;

use App\Contexts\Cards\Domain\Exceptions\CardNotFoundExceptionInterface;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;

interface CardRepositoryInterface
{
    public function persist(Card $card): void;

    /**
     * @throws CardNotFoundExceptionInterface
     */
    public function take(CardId $cardId): Card;
}
