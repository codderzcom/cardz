<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\AddWorkspaceRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\ChangeWorkspaceProfileRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\GetWorkspaceRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\KeeperQueryRequest;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceService;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceService $workspaceService,
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
