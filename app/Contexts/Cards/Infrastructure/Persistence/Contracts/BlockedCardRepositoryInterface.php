<?php

namespace App\Contexts\Cards\Infrastructure\Persistence\Contracts;

use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCard;
use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;

interface BlockedCardRepositoryInterface
{
    public function persist(?BlockedCard $blockedCard = null): void;

    public function take(BlockedCardId $blockedCardId): ?BlockedCard;
}
