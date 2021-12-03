<?php

namespace Cardz\Generic\Identity\Domain\Events\Token;

use Cardz\Generic\Identity\Domain\Model\Token\Token;
use Codderz\Platypus\Infrastructure\Support\Domain\DomainEvent;

final class TokenAssigned extends DomainEvent
{
    public function with(): Token
    {
        return $this->aggregateRoot;
    }

}
