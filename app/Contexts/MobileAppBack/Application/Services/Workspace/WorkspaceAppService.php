<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\Workspaces\Presentation\Controllers\Rpc\RpcAdapter as WorkspacesAdapter;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class WorkspaceAppService
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
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
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

    public function addWorkspace(string $keeperId, string $name, string $description, string $address): ServiceResultInterface
    {
        $result = $this->workspacesAdapter->addWorkspace($keeperId, $name, $description, $address);
        return $this->getBusinessWorkspaceResult($result->getPayload());
    }

    public function changeProfile(string $keeperId, string $workspaceId, string $name, string $description, string $address): ServiceResultInterface
    {
        AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert();
        $this->workspacesAdapter->changeProfile($workspaceId, $name, $description, $address);
        return $this->getBusinessWorkspaceResult($workspaceId);
    }

}
