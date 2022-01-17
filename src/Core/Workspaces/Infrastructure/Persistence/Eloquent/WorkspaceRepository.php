<?php

namespace Cardz\Core\Workspaces\Infrastructure\Persistence\Eloquent;

use App\Models\ESStorage;
use Cardz\Core\Workspaces\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Cardz\Core\Workspaces\Domain\Model\Workspace\Workspace;
use Cardz\Core\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Infrastructure\Exceptions\WorkspaceNotFoundException;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;
use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use JsonException;

class WorkspaceRepository implements WorkspaceRepositoryInterface
{
    use SimpleLoggerTrait;

    public function store(Workspace $workspace): array
    {
        $events = $workspace->releaseEvents();
        $data = [];
        foreach ($events as $event) {
            $data[] = $event->toArray();
        }
        ESStorage::query()->insert($data);
        return $events;
    }

    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function restore(WorkspaceId $workspaceId): Workspace
    {
        $esEvents = $this->getESEvents($workspaceId);

        $events = [];
        foreach ($esEvents as $esEvent) {
            $event = $this->restoreEvent($esEvent);
            if ($event) {
                $events[] = $event;
            }
        }
        return (new Workspace($workspaceId))->apply(...$events);
    }

    /**
     * @return ESStorage[]
     * @throws WorkspaceNotFoundExceptionInterface
     */
    protected function getESEvents(string $workspaceId): array
    {
        $esEvents = ESStorage::query()
            ->where('channel', '=', Workspace::class)
            ->where('stream', '=', $workspaceId)
            ->orderBy('at')
            ->get();
        if ($esEvents->isEmpty()) {
            throw new WorkspaceNotFoundException("Workspace $workspaceId not found");
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
