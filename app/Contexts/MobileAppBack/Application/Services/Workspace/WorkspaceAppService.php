<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\WorkspacesContextInterface;

class WorkspaceAppService
{
    public function __construct(
        private WorkspacesContextInterface $workspacesContext,
        private BusinessWorkspaceReadStorageInterface $businessWorkspaceReadStorage,
    ) {
    }

    public function getBusinessWorkspaces(string $collaboratorId): array
    {
        return $this->businessWorkspaceReadStorage->allForCollaborator($collaboratorId);
    }

    public function getBusinessWorkspace(string $workspaceId): BusinessWorkspace
    {
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): BusinessWorkspace
    {
        $workspaceId = $this->workspacesContext->add($keeperId, $name, $description, $address);
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): BusinessWorkspace
    {
        $this->workspacesContext->changeProfile($workspaceId, $name, $description, $address);
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

}
