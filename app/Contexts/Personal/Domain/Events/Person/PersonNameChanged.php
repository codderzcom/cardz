<?php

namespace App\Contexts\Personal\Domain\Events\Person;

use App\Contexts\Personal\Domain\Model\Person\PersonId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class PersonNameChanged extends BasePersonDomainEvent
{

    public static function with(PersonId $personId): self
    {
        return new self($personId);
    }
}
