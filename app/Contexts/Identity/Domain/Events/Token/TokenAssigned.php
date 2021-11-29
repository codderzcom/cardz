<?php

namespace App\Contexts\Identity\Domain\Events\Token;

use App\Contexts\Identity\Domain\Model\Token\Token;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

final class TokenAssigned extends DomainEvent
{
    public function with(): Token
    {
        return $this->aggregateRoot;
    }

}
