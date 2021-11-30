<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ACL\Workspaces;

use Cardz\Core\Workspaces\Application\Commands\AddWorkspace;
use Cardz\Core\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use Cardz\Support\MobileAppGateway\Integration\Contracts\WorkspacesContextInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;

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
