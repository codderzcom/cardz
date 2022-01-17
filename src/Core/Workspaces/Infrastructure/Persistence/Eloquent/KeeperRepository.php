<?php

namespace Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Workspaces\Domain\Exceptions\KeeperNotFoundExceptionInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Exceptions\KeeperNotFoundException;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use JsonException;

class KeeperRepository implements KeeperRepositoryInterface
{
    use SimpleLoggerTrait;

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
            $event = $this->restoreEvent($esEvent);
            if ($event) {
                $events[] = $event;
            }
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

    protected function restoreEvent(ESStorage $esEvent): ?AggregateEventInterface
    {
        $eventClass = $esEvent->name;
        try {
            $changeset = json_decode($esEvent->changeset, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            $this->error("Unable to restore $eventClass event.");
            return null;
        }
        return [$eventClass, 'from']($changeset);
    }
}
