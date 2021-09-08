<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Workspaces\WorkspacesAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class WorkspaceService
{
    public function __construct(
        private WorkspacesAdapter $workspacesAdapter,
        private BusinessWorkspaceReadStorageInterface $businessWorkspaceReadStorage,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getBusinessWorkspaces(string $keeperId): ServiceResultInterface
    {
        $workspaces = $this->businessWorkspaceReadStorage->allForKeeper($keeperId);
        return $this->serviceResultFactory->ok($workspaces);
    }

    public function getBusinessWorkspace(string $workspaceId): ServiceResultInterface
    {
        $workspace = $this->businessWorkspaceReadStorage->find($workspaceId);
        if ($workspace === null) {
            return $this->serviceResultFactory->notFound("Workspace $workspaceId not found");
        }
        return $this->serviceResultFactory->ok($workspace);
    }

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspacesAdapter->addWorkspace($keeperId, $name, $description, $address);
        if ($result->isNotOk()) {
            return $result;
        }

        $workspaceId = $result->getPayload();

        $workspace = $this->businessWorkspaceReadStorage->find($workspaceId);
        if ($workspace === null) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId could not be found after creation");
        }

        return $this->serviceResultFactory->ok($workspace);
    }

    public function changeProfile(string $workspaceId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspacesAdapter->changeProfile($workspaceId, $name, $description, $address);
        if ($result->isNotOk()) {
            return $result;
        }

        $workspace = $this->businessWorkspaceReadStorage->find($workspaceId);
        if ($workspace === null) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId not found");
        }

        return $this->serviceResultFactory->ok($workspace);
    }

}
