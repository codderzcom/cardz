<?php

namespace App\Contexts\Collaboration\Application\Commands\Keeper;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class KeepWorkspace implements KeepWorkspaceCommandInterface
{
    private function __construct(
        private string $relationId,
        private string $keeperId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $keeperId, string $workspaceId): self
    {
        return new self(RelationId::makeValue(), $keeperId, $workspaceId);
    }

    public function getRelationId(): RelationId
    {
        return RelationId::of($this->relationId);
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }
}
