<?php

namespace App\Contexts\Collaboration\Integration\Consumers;

use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Workspaces\Integration\Events\NewWorkspaceRegistered;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;
use function json_try_decode;

final class WorkspacesNewWorkspaceRegisteredConsumer implements IntegrationEventConsumerInterface
{
    public function __construct(
        private KeeperAppService $keeperAppService,
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
        $this->keeperAppService->keepWorkspace($addedWorkspace->keeperId, $addedWorkspace->workspaceId);
    }

}
