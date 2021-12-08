<?php

namespace Cardz\Core\Workspaces\Domain\Persistence\Contracts;

use Cardz\Core\Workspaces\Domain\Model\Workspace\Keeper;
use Cardz\Core\Workspaces\Domain\Model\Workspace\KeeperId;
use Codderz\Platypus\Contracts\Domain\AggregateEventInterface;

interface KeeperRepositoryInterface
{
    /**
     * @return AggregateEventInterface[]
     */
    public function store(Keeper $keeper): array;

    public function restore(KeeperId $keeperId): Keeper;

}
