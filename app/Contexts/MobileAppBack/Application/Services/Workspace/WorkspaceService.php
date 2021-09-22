<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
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

    public function getBusinessWorkspace(string $keeperId, string $workspaceId): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not in for keeper $keeperId");
        }

        return $this->getBusinessWorkspaceResult($workspaceId);
    }

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspacesAdapter->addWorkspace($keeperId, $name, $description, $address);
        if ($result->isNotOk()) {
            return $result;
        }

        $workspaceId = $result->getPayload();
        return $this->getBusinessWorkspaceResult($workspaceId);
    }

    public function changeProfile(string $keeperId, string $workspaceId, string $name, string $description, string $address): ServiceResultInterface
    {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not in for keeper $keeperId");
        }

        $result = $this->workspacesAdapter->changeProfile($workspaceId, $name, $description, $address);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getBusinessWorkspaceResult($workspaceId);
    }

    private function getBusinessWorkspaceResult(string $workspaceId): ServiceResultInterface
    {
        $workspace = $this->businessWorkspaceReadStorage->find($workspaceId);
        if ($workspace === null) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId not found");
        }

        return $this->serviceResultFactory->ok($workspace);
    }

}
