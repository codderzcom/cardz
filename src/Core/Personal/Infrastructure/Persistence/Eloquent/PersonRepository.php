<?php

namespace Cardz\Core\Personal\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Personal\Domain\Exception\PersonNotFoundExceptionInterface;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonRepositoryInterface;
use Cardz\Core\Personal\Infrastructure\Exceptions\PersonNotFoundException;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use JsonException;

class PersonRepository implements PersonRepositoryInterface
{
    use SimpleLoggerTrait;

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
            $event = $this->restoreEvent($esEvent);
            if ($event) {
                $events[] = $event;
            }
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

    protected function restoreEvent(ESStorage $esEvent): ?AggregateEventInterface
    {
        $eventClass = $esEvent->name;
        try {
            $changeset = json_decode($esEvent->changeset, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            $this->error("Unable to restore $eventClass event.");
            return null;
        }
        return [$eventClass, 'from']($changeset);
    }
}
