<?php

namespace Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Exceptions\KeeperNotFoundException;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

class KeeperRepository implements KeeperRepositoryInterface
{
    public function store(Keeper $keeper): array
    {
        $events = $keeper->releaseEvents();
        $data = [];
        foreach ($events as $event) {
            $data[] = $event->toArray();
        }
        ESStorage::query()->insert($data);
        return $events;
    }

    /**
     * @throws KeeperNotFoundExceptionInterface
     */
    public function restore(KeeperId $keeperId): Keeper
    {
        $esEvents = $this->getESEvents($keeperId);

        $events = [];
        foreach ($esEvents as $esEvent) {
            $events[] = $this->restoreEvent($esEvent);
        }
        return (new Keeper($keeperId))->apply(...$events);
    }

    /**
     * @return ESStorage[]
     * @throws KeeperNotFoundExceptionInterface
     */
    protected function getESEvents(string $keeperId): array
    {
        $esEvents = ESStorage::query()
            ->where('channel', '=', Keeper::class)
            ->where('stream', '=', $keeperId)
            ->orderBy('at')
            ->get();
        if ($esEvents->isEmpty()) {
            throw new KeeperNotFoundException("Keeper $keeperId not found");
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
