<?php

namespace Cardz\Core\Personal\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Infrastructure\Exceptions\PersonNotFoundException;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

class PersonRepository implements PersonRepositoryInterface
{
    public function store(Person $person): array
    {
        $events = $person->releaseEvents();
        $data = [];
        foreach ($events as $event) {
            $data[] = $event->toArray();
        }
        ESStorage::query()->insert($data);
        return $events;
    }

    /**
     * @throws PersonNotFoundExceptionInterface
     */
    public function restore(PersonId $personId): Person
    {
        $esEvents = $this->getESEvents($personId);

        $events = [];
        foreach ($esEvents as $esEvent) {
            $events[] = $this->restoreEvent($esEvent);
        }
        return (new Person($personId))->apply(...$events);
    }

    /**
     * @return ESStorage[]
     * @throws PersonNotFoundExceptionInterface
     */
    protected function getESEvents(string $personId): array
    {
        $esEvents = ESStorage::query()
            ->where('channel', '=', Person::class)
            ->where('stream', '=', $personId)
            ->orderBy('at')
            ->get();
        if ($esEvents->isEmpty()) {
            throw new PersonNotFoundException("Person $personId not found");
        }
        return $esEvents->all();
    }

    protected function restoreEvent(ESStorage $esEvent): AggregateEventInterface
    {
        $eventClass = $esEvent->name;
        $changeset = json_decode($esEvent->changeset, true);
        return [$eventClass, 'from']($changeset);
    }
}
