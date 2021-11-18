<?php

namespace App\Contexts\Collaboration\Tests\Support\Mocks;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;

class RelationInMemoryRepository implements RelationRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Relation $relation): void
    {
        static::$storage[$relation->collaboratorId . $relation->workspaceId] = $relation;
    }

    public function find(CollaboratorId $collaboratorId, WorkspaceId $workspaceId): Relation
    {
        return static::$storage[$collaboratorId . $workspaceId];
    }
}
