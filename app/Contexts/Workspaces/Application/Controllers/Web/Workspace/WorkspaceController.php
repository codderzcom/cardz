<?php

namespace App\Contexts\Workspaces\Application\Controllers\Web\Workspace;

use App\Contexts\Workspaces\Application\Controllers\Web\BaseController;
use App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands\{AddWorkspaceRequest, ChangeWorkspaceProfileRequest};
use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceAppService $workspaceAppService,
    ) {
    }

    public function add(AddWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->workspaceAppService->add(
            $request->keeperId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }

    public function changeProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        return $this->response($this->workspaceAppService->changeProfile(
            $request->workspaceId,
            $request->name,
            $request->description,
            $request->address,
        ));
    }
}
