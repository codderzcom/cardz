<?php

namespace Cardz\Core\Cards\Domain\Persistence\Contracts;

use Cardz\Core\Cards\Domain\Exceptions\CardNotFoundExceptionInterface;
use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Card\CardId;

interface CardRepositoryInterface
{
    public function persist(Card $card): void;

    /**
     * @throws CardNotFoundExceptionInterface
     */
    public function take(CardId $cardId): Card;
}
