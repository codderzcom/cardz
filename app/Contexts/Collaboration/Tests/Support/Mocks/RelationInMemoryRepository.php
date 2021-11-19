<?php

namespace App\Contexts\Collaboration\Tests\Support\Mocks;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;

class RelationInMemoryRepository implements RelationRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Relation $relation): void
    {
        if ($relation->isLeft()) {
            unset(static::$storage[$relation->collaboratorId . $relation->workspaceId]);
            return;
        }
        static::$storage[$relation->collaboratorId . $relation->workspaceId] = $relation;
    }

    public function find(CollaboratorId $collaboratorId, WorkspaceId $workspaceId): Relation
    {
        $key = $collaboratorId . $workspaceId;
        return static::$storage[$key] ?? throw new RelationNotFoundException();
    }
}
