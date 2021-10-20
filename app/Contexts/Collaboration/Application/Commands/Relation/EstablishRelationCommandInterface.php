<?php

namespace App\Contexts\Collaboration\Application\Commands\Relation;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

interface EstablishRelationCommandInterface extends CommandInterface
{
    public function getRelationId(): RelationId;

    public function getCollaboratorId(): CollaboratorId;

    public function getWorkspaceId(): WorkspaceId;

    public function getRelationType(): RelationType;
}
