<?php

namespace Cardz\Support\Collaboration\Application\Commands\Relation;

use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;
use JetBrains\PhpStorm\Pure;

final class RemoveRelation implements CommandInterface
{
    private function __construct(
        private string $collaboratorId,
        private string $workspaceId,
    ) {
    }

    #[Pure]
    public static function of(string $collaboratorId, string $workspaceId): self
    {
        return new self($collaboratorId, $workspaceId);
    }

    public function getCollaboratorId(): CollaboratorId
    {
        return CollaboratorId::of($this->collaboratorId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }
}
