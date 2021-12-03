<?php

namespace Cardz\Support\Collaboration\Domain\Persistence\Contracts;

use Cardz\Support\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Relation\Relation;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface RelationRepositoryInterface
{
    public function persist(Relation $relation): void;

    /**
     * @throws RelationNotFoundExceptionInterface
     */
    public function find(CollaboratorId $collaboratorId, WorkspaceId $workspaceId): Relation;
}
