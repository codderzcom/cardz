<?php

namespace App\Contexts\Personal\Application\Contracts;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;

interface PersonRepositoryInterface
{
    public function persist(Person $person): void;

    public function take(PersonId $personId): ?Person;
}
