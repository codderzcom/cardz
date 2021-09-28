<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace;

use App\Contexts\Workspaces\Application\Services\WorkspaceAppService;
use App\Contexts\Workspaces\Presentation\Controllers\Http\BaseController;
use App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\Commands\{AddWorkspaceRequest, ChangeWorkspaceProfileRequest};
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
