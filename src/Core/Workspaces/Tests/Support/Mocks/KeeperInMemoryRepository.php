<?php

namespace Cardz\Core\Workspaces\Tests\Support\Mocks;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\KeeperRepositoryInterface;

class KeeperInMemoryRepository implements KeeperRepositoryInterface
{
    protected static array $events = [];

    public function store(Keeper $keeper): array
    {
        $id = (string) $keeper->keeperId;
        $events = $keeper->releaseEvents();
        static::$events[$id] ??= [];
        static::$events[$id] = [...static::$events[$id], ...$events];
        return $events;
    }

    public function restore(KeeperId $keeperId): Keeper
    {
        $events = collect(static::$events[(string) $keeperId] ??= [])->sortByDesc(function ($event, $key) {
            return $event->at()->timestamp;
        });
        return (new Keeper($keeperId))->apply(...$events->all());
    }

}
