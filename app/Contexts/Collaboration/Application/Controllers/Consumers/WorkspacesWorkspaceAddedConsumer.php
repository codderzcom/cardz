<?php

namespace App\Contexts\Collaboration\Application\Controllers\Consumers;

use App\Contexts\Collaboration\Application\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded as WorkspacesWorkspaceAdded;

final class WorkspacesWorkspaceAddedConsumer implements Informable
{
    public function __construct(
        private KeeperAppService $keeperAppService,
        private AddedWorkspaceReadStorageInterface $addedWorkspaceReadStorage,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        //ToDo: InterContext dependency.
        return $reportable instanceof WorkspacesWorkspaceAdded;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var WorkspacesWorkspaceAdded $event */
        $event = $reportable;
        $addedWorkspace = $this->addedWorkspaceReadStorage->find($event->id());
        if ($addedWorkspace === null) {
            return;
        }
        $this->keeperAppService->bindWorkspace($addedWorkspace->collaboratorId, $addedWorkspace->workspaceId);
    }
}
