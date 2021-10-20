<?php

namespace App\Contexts\Collaboration\Application\Commands\Keeper;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\Commands\CommandInterface;

interface KeepWorkspaceCommandInterface extends CommandInterface
{
    public function getRelationId(): RelationId;

    public function getKeeperId(): KeeperId;

    public function getWorkspaceId(): WorkspaceId;
}
