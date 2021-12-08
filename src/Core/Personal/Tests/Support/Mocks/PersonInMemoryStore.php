<?php

namespace Cardz\Core\Personal\Tests\Support\Mocks;

use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonStoreInterface;

class PersonInMemoryStore implements PersonStoreInterface
{
    protected static array $events = [];

    public function store(Person $person): array
    {
        $events = $person->releaseEvents();
        $id = (string) $person->personId;
        static::$events[$id] ??= [];
        static::$events[$id] = [...static::$events[$id], ... $events];
        return $events;
    }

    public function restore(PersonId $personId): Person
    {
        $events = collect(static::$events[(string) $personId] ??= [])->sortByDesc(function ($event, $key) {
            return $event->at()->timestamp;
        });
        return (new Person($personId))->apply(...$events->all());
    }

}
