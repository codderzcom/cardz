<?php

namespace Cardz\Core\Personal\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Cardz\Core\Personal\Domain\Persistence\Contracts\PersonStoreInterface;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

class PersonStore implements PersonStoreInterface
{
    protected const CONTEXT = 'personal';
    protected const CHANNEL = 'person';
    protected const VERSION = 1;
    protected const EVENT_NAMESPACE = 'Cardz\\Core\\Personal\\Domain\\Events\\Person\\';

    public function store(Person $person): array
    {
        $events = $person->releaseEvents();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'context' => $this::CONTEXT,
                'channel' => $this::CHANNEL,
                'name' => $event::shortName(),
                'stream' => (string) $event->stream(),
                'recorded_at' => $event->at(),
                'version' => $this::VERSION,
                'changeset' => json_encode($event->changeset()),
            ];
        }
        ESStorage::query()->insert($data);
        return $events;
    }

    public function restore(PersonId $personId): Person
    {
        $esEvents = ESStorage::query()
            ->where('context', '=', $this::CONTEXT)
            ->where('channel', '=', $this::CHANNEL)
            ->where('stream', '=', (string) $personId)
            ->orderBy('recorded_at')
            ->get();
        $events = [];
        foreach ($esEvents as $esEvent) {
            $events[] = $this->restoreEvent($esEvent);
        }
        return (new Person($personId))->apply(...$events);
    }

    protected function restoreEvent(ESStorage $esEvent): AggregateEventInterface
    {
        $eventClass = $this::EVENT_NAMESPACE . $esEvent->name;
        $changeset = json_decode($esEvent->changeset, true);
        return [$eventClass, 'from']($changeset);
    }
}
