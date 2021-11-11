<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Workspaces;

use App\Contexts\MobileAppBack\Integration\Contracts\WorkspacesContextInterface;
use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Shared\Contracts\Commands\CommandBusInterface;

class MonolithWorkspacesAdapter implements WorkspacesContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function add(string $keeperId, string $name, string $description, string $address): string
    {
        $command = AddWorkspace::of($keeperId, $name, $description, $address);
        $this->commandBus->dispatch($command);
        return $command->getWorkspaceId();
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): string
    {
        $command = ChangeWorkspaceProfile::of($workspaceId, $name, $description, $address);
        $this->commandBus->dispatch($command);
        return $command->getWorkspaceId();
    }

}
