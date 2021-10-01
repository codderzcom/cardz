<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Rpc;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Shared\Contracts\Commands\CommandBusInterface;

class RpcAdapter
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): void
    {
        $command = AddWorkspace::of($keeperId, $name, $description, $address);
        $this->commandBus->dispatch($command);
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): void
    {
        $command = ChangeWorkspaceProfile::of($workspaceId, $name, $description, $address);
        $this->commandBus->dispatch($command);
    }
}
