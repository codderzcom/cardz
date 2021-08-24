<?php

namespace App\Contexts\Cards\Infrasctructure\Persistence;

use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardAggregateRoot;
use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;

class BlockedCardRepository
{
    public function persist(BlockedCardAggregateRoot $blockedCard): void
    {
    }

    public function take(BlockedCardId $blockedCardId): ?BlockedCardAggregateRoot
    {
    }
}
