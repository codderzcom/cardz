<?php

namespace App\Contexts\Cards\Domain\Model\BlockedCard;

use App\Contexts\Cards\Domain\Events\BlockedCard\BlockedCardUnblocked;
use App\Contexts\Cards\Domain\Model\AggregateRoot;
use Carbon\Carbon;

class BlockedCard extends AggregateRoot
{
    public function __construct(
        public BlockedCardId $blockedCardId,
        public ?Carbon $blocked = null
    ) {
    }

    public function unblock(): BlockedCardUnblocked
    {
        $this->blocked = null;
        return BlockedCardUnblocked::with($this->blockedCardId);
    }
}
