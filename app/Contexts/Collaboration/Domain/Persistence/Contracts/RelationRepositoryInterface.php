<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\RelationNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

interface RelationRepositoryInterface
{
    public function persist(Relation $relation): void;

    /**
     * @throws RelationNotFoundExceptionInterface
     */
    public function find(CollaboratorId $collaboratorId, WorkspaceId $workspaceId): Relation;
}
