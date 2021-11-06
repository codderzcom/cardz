<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceAppService;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\WorkspacesContextInterface;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\AddWorkspaceRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\ChangeWorkspaceProfileRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\KeeperQueryRequest;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceAppService $workspaceService,
    ) {
    }

    public function getWorkspacesForKeeper(KeeperQueryRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->getBusinessWorkspaces(
            $request->keeperId,
        ));
    }

    public function getWorkspace(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->getBusinessWorkspace(
            $request->keeperId,
            $request->workspaceId,
        ));
    }

    public function addWorkspace(AddWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->addWorkspace(
            $request->keeperId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }

    public function changeWorkspaceProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        return $this->response($this->workspaceService->changeProfile(
            $request->collaboratorId,
            $request->workspaceId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }
}
