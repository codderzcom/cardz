<?php

namespace Cardz\Core\Cards\Tests\Support\Mocks;

use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;

class CardInMemoryRepository implements CardRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Card $card): void
    {
        static::$storage[(string) $card->cardId] = $card;
    }

    public function take(CardId $cardId): Card
    {
        return static::$storage[(string) $cardId];
    }

}
