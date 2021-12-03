<?php

namespace Cardz\Core\Cards\Domain\Events\Card;

use Cardz\Core\Cards\Domain\Model\Card\Card;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

abstract class BaseCardDomainEvent extends DomainEvent
{
    public function with(): Card
    {
        return $this->aggregateRoot;
    }
}
