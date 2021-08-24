<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Events\BaseDomainEvent;
use App\Contexts\Cards\Domain\Model\Card\CardId;

abstract class BaseCardDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public CardId $cardId
    ) {
        parent::__construct();
    }
}
