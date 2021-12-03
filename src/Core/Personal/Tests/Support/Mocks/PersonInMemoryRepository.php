<?php

namespace Cardz\Core\Personal\Tests\Support\Mocks;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;

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
