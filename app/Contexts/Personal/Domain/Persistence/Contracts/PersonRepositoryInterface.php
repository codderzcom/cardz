<?php

namespace App\Contexts\Personal\Domain\Persistence\Contracts;

use App\Contexts\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;

interface PersonRepositoryInterface
{
    public function persist(Person $person): void;

    /**
     * @throws PersonNotFoundExceptionInterface
     */
    public function take(PersonId $personId): Person;
}
