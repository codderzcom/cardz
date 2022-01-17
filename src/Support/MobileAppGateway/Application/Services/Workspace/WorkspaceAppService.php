<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Workspace;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Workspace\BusinessWorkspace;
use Cardz\Support\MobileAppGateway\Infrastructure\Exceptions\BusinessWorkspaceNotFoundException;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use Cardz\Support\MobileAppGateway\Integration\Contracts\WorkspacesContextInterface;

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

    /**
     * @throws BusinessWorkspaceNotFoundException
     */
    public function getBusinessWorkspace(string $workspaceId): BusinessWorkspace
    {
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

    /**
     * @throws BusinessWorkspaceNotFoundException
     */
    public function addWorkspace(string $keeperId, string $name, string $description, string $address): BusinessWorkspace
    {
        $workspaceId = $this->workspacesContext->add($keeperId, $name, $description, $address);
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

    /**
     * @throws BusinessWorkspaceNotFoundException
     */
    public function changeProfile(string $workspaceId, string $name, string $description, string $address): BusinessWorkspace
    {
        $this->workspacesContext->changeProfile($workspaceId, $name, $description, $address);
        return $this->businessWorkspaceReadStorage->find($workspaceId);
    }

}
