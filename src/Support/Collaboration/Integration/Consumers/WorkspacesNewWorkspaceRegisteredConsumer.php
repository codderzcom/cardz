<?php

namespace Cardz\Support\Collaboration\Integration\Consumers;

use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Cardz\Support\Collaboration\Application\Commands\Keeper\KeepWorkspace;
use Cardz\Support\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventConsumerInterface;
use function json_try_decode;

final class WorkspacesNewWorkspaceRegisteredConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private AddedWorkspaceReadStorageInterface $addedWorkspaceReadStorage,
    ) {
    }

    public function consumes(): array
    {
        // TODO: here's a context link
        return [
            NewWorkspaceRegistered::class,
        ];
    }

    public function handle(string $event): void
    {
        $data = json_try_decode($event, true);
        $workspaceId = $data['workspaceId'] ?? null;
        //ToDo: переделать на query?
        $addedWorkspace = $this->addedWorkspaceReadStorage->find($workspaceId);
        if ($addedWorkspace === null) {
            return;
        }
        $this->commandBus->dispatch(KeepWorkspace::of($addedWorkspace->keeperId, $addedWorkspace->workspaceId));
    }

}
