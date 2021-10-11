<?php

namespace App\Contexts\Cards\Domain\Events\Card;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseCardDomainEvent extends DomainEvent
{
    public function with(): Card
    {
        return $this->aggregateRoot;
    }
}
