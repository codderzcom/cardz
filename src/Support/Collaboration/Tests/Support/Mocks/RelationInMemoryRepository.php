<?php

namespace Cardz\Support\Collaboration\Tests\Support\Mocks;

use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Exceptions\RelationNotFoundException;

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
