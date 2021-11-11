<?php

namespace App\Contexts\Auth\Domain\Events\Token;

use App\Contexts\Auth\Domain\Model\Token\Token;
use App\Shared\Infrastructure\Support\Domain\DomainEvent;

final class TokenAssigned extends DomainEvent
{
    public function with(): Token
    {
        return $this->aggregateRoot;
    }

}
