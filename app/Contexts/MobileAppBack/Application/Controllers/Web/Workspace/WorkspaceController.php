<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\AddWorkspaceRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\ChangeWorkspaceProfileRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\IssueCardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\GetWorkspaceRequest;
use App\Contexts\MobileAppBack\Application\Services\Workspace\WorkspaceService;
use App\Models\Plan as EloquentPlan;
use App\Models\Workspace as EloquentWorkspace;
use Illuminate\Http\JsonResponse;

class WorkspaceController extends BaseController
{
    public function __construct(
        private WorkspaceService $workspaceService,
    ) {
    }

    public function listAll(): JsonResponse
    {
        $workspaces = EloquentWorkspace::query()->all();
        return $this->success($workspaces);
    }

    public function listAllPlans(ListAllPlansRequest $request): JsonResponse
    {
        $plans = EloquentPlan::query()->where('workspaceId', '=', $request->workspaceId);
        return $this->success($plans);
    }

    public function getWorkspace(GetWorkspaceRequest $request): JsonResponse
    {
        $workspace = EloquentWorkspace::query()->find($request->workspaceId);
        if ($workspace === null) {
            return $this->notFound();
        }
        return $this->success($workspace->toArray());
    }

    public function add(AddWorkspaceRequest $request): JsonResponse
    {
        $this->workspaceService->addWorkspace($request->customerId);
        return $this->success();
    }

    public function changeProfile(ChangeWorkspaceProfileRequest $request): JsonResponse
    {
        $this->workspaceService->changeProfile($request->customerId);
        return $this->success();
    }

    public function issueCard(IssueCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->issueCard(
            $request->planId,
            $request->customerId,
            $request->description,
        ));
    }
}
