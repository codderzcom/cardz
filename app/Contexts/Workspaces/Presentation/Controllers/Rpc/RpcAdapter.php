<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Rpc;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Rpc\RpcResponseInterface;
use App\Shared\Infrastructure\Rpc\RpcAdapterTrait;

/**
 * @method RpcResponseInterface addWorkspace(string $keeperId, string $name, string $description, string $address)
 * @method RpcResponseInterface changeProfile(string $workspaceId, string $name, string $description, string $address)
 */
class RpcAdapter
{
    use RpcAdapterTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    private function addWorkspaceMethod(string $keeperId, string $name, string $description, string $address): string
    {
        $command = AddWorkspace::of($keeperId, $name, $description, $address);
        $this->commandBus->dispatch($command);
        return (string) $command->getWorkspaceId();
    }

    private function changeProfileMethod(string $workspaceId, string $name, string $description, string $address): string
    {
        $command = ChangeWorkspaceProfile::of($workspaceId, $name, $description, $address);
        $this->commandBus->dispatch($command);
        return (string) $command->getWorkspaceId();
    }
}
