<?php

namespace Cardz\Support\Collaboration\Application\Commands\Keeper;

use Cardz\Support\Collaboration\Domain\Model\Relation\RelationId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

final class KeepWorkspace implements CommandInterface
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
