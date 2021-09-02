<?php

namespace App\Contexts\Cards\Domain\Events\BlockedCard;

use App\Contexts\Cards\Domain\Events\BaseDomainEvent;
use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class BlockedCardUnblocked extends BaseDomainEvent
{
    protected function __construct(
        public BlockedCardId $blockedCardId
    ) {
        parent::__construct();
    }

    public static function with(BlockedCardId $blockedCardId): self
    {
        return new self($blockedCardId);
    }
}
