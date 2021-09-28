<?php

namespace App\Contexts\Collaboration\Application\Controllers\Consumers;

use App\Contexts\Collaboration\Application\Contracts\AddedWorkspaceReadStorageInterface;
use App\Contexts\Collaboration\Application\Services\KeeperAppService;
use App\Contexts\Workspaces\Application\IntegrationEvents\WorkspaceAdded as WorkspacesWorkspaceAdded;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;

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
