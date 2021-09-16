<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\{AddPlanRequest,
    AddPlanRequirementRequest,
    ChangePlanDescriptionRequest,
    ChangePlanRequirementRequest,
    PlanCommandRequest,
    RemovePlanRequirementRequest};
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\GetPlanRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\GetWorkspaceRequest;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanService;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function getPlans(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspacePlans(
            $request->workspaceId,
        ));
    }

    public function getPlan(GetPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspacePlan(
            $request->workspaceId,
            $request->planId,
        ));
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->add(
            $request->workspaceId,
            $request->description,
        ));
    }

    public function launch(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->launch(
            $request->planId,
        ));
    }

    public function stop(PlanCommandRequest $request): JsonResponse
    {
        $this->response($this->planService->stop(
            $request->planId,
        ));
    }

    public function archive(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->archive(
            $request->planId,
        ));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeDescription(
            $request->planId,
            $request->description,
        ));
    }

    public function addRequirement(AddPlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->addRequirement(
            $request->planId,
            $request->description,
        ));
    }

    public function removeRequirement(RemovePlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->removeRequirement(
            $request->planId,
            $request->description,
        ));
    }

    public function changeRequirement(ChangePlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeRequirement(
            $request->planId,
            $request->description,
        ));
    }

}
