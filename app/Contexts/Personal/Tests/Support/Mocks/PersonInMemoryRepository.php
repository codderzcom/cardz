<?php

namespace App\Contexts\Personal\Tests\Support\Mocks;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Contexts\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;

class PersonInMemoryRepository implements PersonRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Person $person): void
    {
        static::$storage[(string) $person->personId] = $person;
    }

    public function take(PersonId $personId): Person
    {
        return static::$storage[(string) $personId];
    }
}
