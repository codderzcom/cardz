<?php

namespace App\Contexts\Cards\Infrasctructure\Persistence;

use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCard;
use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;

class BlockedCardRepository
{
    public function persist(BlockedCard $blockedCard): void
    {
    }

    public function take(BlockedCardId $blockedCardId): ?BlockedCard
    {
    }
}
