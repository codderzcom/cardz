<?php

namespace App\Contexts\Workspaces\Domain\Model\Workspace;

use App\Contexts\Workspaces\Domain\Model\Shared\AggregateRoot;

final class Keeper extends AggregateRoot
{
    public function __construct(
        public KeeperId $keeperId,
    ) {
    }

    public function keepWorkspace(WorkspaceId $workspaceId, string $name, string $description, string $address): Workspace
    {
        return Workspace::add(
            $workspaceId,
            $this->keeperId,
            Profile::of($name, $description, $address),
        );
    }
}
